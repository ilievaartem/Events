<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\UsersCreateRequest;
use App\Http\Requests\Users\UsersUpdateRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Constants\Request\UserRequestConstants;
use App\Factory\User\UploadUserAvatarDTOFactory;
use App\Http\Requests\Users\UserUploadAvatarRequest;
use Ramsey\Uuid\Uuid;

class UserController extends Controller
{

    public function __construct(private UserService $userService)
    {
        $this->userService = $userService;
    }
    public function index(): JsonResponse
    {
        return response()->json($this->userService->index());
    }

    public function create(Request $request): JsonResponse
    {
        $name = $request->input(UserRequestConstants::NAME);
        $email = $request->input(UserRequestConstants::EMAIL);
        $role = $request->input(UserRequestConstants::ROLE);
        $telephone = $request->input(UserRequestConstants::ROLE);
        $password = $request->input(UserRequestConstants::PASSWORD);
        return response()->json($this->userService->create($name, $email, $role, $telephone, $password));
    }
    public function update(Request $request, string $id): JsonResponse
    {
        $name = $request->input(UserRequestConstants::NAME);
        $email = $request->input(UserRequestConstants::EMAIL);
        $password = $request->input(UserRequestConstants::PASSWORD);
        return response()->json($this->userService->update($name, $email, $password, $id));
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
    public function userEvents(string $id): JsonResponse
    {
        return response()->json($this->userService->userEvents($id));
    }
    public function userQuestions(string $id): JsonResponse
    {
        return response()->json($this->userService->userQuestions($id));
    }
    public function userComments(string $id): JsonResponse
    {
        return response()->json($this->userService->userComments($id));
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
