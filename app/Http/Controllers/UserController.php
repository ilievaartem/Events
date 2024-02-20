<?php

namespace App\Http\Controllers;

use App\Http\Requests\Users\UsersCreateRequest;
use App\Http\Requests\Users\UsersUpdateRequest;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Constants\Request\UserRequestConstants;
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
        $id = Uuid::uuid4()->toString();
        $name = $request->input(UserRequestConstants::NAME);
        $email = $request->input(UserRequestConstants::EMAIL);
        $role = $request->input(UserRequestConstants::ROLE);
        $telephone = $request->input(UserRequestConstants::ROLE);
        $password = $request->input(UserRequestConstants::PASSWORD);
        return response()->json($this->userService->create($id, $name, $email, $role, $telephone, $password));
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
        return response()->json($this->userService->delete($id));

    }
    public function show(string $id): JsonResponse
    {
        return response()->json($this->userService->show($id));
    }
    public function userEvents(string $id): JsonResponse
    {
        return response()->json($this->userService->userEvents($id));
    }
    public function addPhoto(Request $request, string $id)
    {


        $photo = $request->file('photo');
        $photoExtension = $request->file('photo')->extension();
        return response()->json(
            $this->userService->updatePhotos(
                $id,
                file_get_contents($photo),
                $photoExtension
            )
        );

    }
}
