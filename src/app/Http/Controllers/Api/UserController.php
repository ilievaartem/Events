<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Users\UsersCreateRequest;
use App\Http\Requests\Users\UsersUpdateRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Constants\Request\UserRequestConstants;
use App\Factory\User\CreateUserDTOFactory;
use App\Factory\User\UpdateUserDTOFactory;
use App\Factory\User\UploadUserAvatarDTOFactory;
use App\Http\Requests\Users\UserUploadAvatarRequest;
use Ramsey\Uuid\Uuid;

class UserController extends Controller
{

    public function __construct(private readonly UserService $userService)
    {
    }
    public function index(): JsonResponse
    {
        return response()->json($this->userService->index());
    }

    public function create(UsersCreateRequest $request, CreateUserDTOFactory $createUserDTOFactory): JsonResponse
    {
        return response()->json($this->userService->create($createUserDTOFactory->make($request)));
    }
    public function update(Request $request, string $id, UpdateUserDTOFactory $updateUserDTOFactory): JsonResponse
    {
        return response()->json($this->userService->update($updateUserDTOFactory->make($request, $id)));
    }
    public function delete(string $id): JsonResponse
    {
        return response()->json(['success' => $this->userService->delete($id)]);
    }
    public function banned(string $id): JsonResponse
    {
        return response()->json($this->userService->banned($id));
    }
    public function show(string $id): JsonResponse
    {
        return response()->json($this->userService->show($id));
    }

    public function addPhoto(
        UserUploadAvatarRequest $request,
        UploadUserAvatarDTOFactory $uploadUserAvatarDTOFactory,
        string $id
    ): JsonResponse {
        $createDTOPhotos = $uploadUserAvatarDTOFactory->make($request, $id);

        return response()->json(
            $this->userService->uploadPhotos(
                $id,
                $createDTOPhotos
            )
        );
    }
    public function deletePhoto(string $id): JsonResponse
    {
        return response()->json(['success' => $this->userService->deletePhoto($id)]);
    }
}
