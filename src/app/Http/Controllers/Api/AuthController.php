<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use App\Constants\Request\UserRequestConstants;
use App\Factory\Auth\AuthRegisterDTOFactory;
use App\Http\Requests\Auth\AuthRegisterRequest;

class AuthController extends Controller
{

    public function __construct(
        private readonly AuthService $authService
    ) {
        $this->middleware('auth:api', ['except' => ['login', 'register', 'logout']]);
    }
    public function register(AuthRegisterRequest $request, AuthRegisterDTOFactory $authRegisterDTOFactory)
    {
        return response()->json($this->authService->register($authRegisterDTOFactory->make($request)));
    }

    public function login(Request $request)
    {
        return response()->json(
            $this->authService->login(
                $request->input(UserRequestConstants::EMAIL),
                $request->input(UserRequestConstants::PASSWORD)
            )
        );
    }


    // public function me()
    // {
    //     return response()->json(auth()->user());
    // }



    public function logout(): JsonResponse
    {
        return response()->json(['success' => $this->authService->logout()]);
    }





}
