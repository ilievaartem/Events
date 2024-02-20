<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use App\Constants\Request\UserRequestConstants;

class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct(
        private readonly AuthService $authService
    ) {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function register(Request $request)
    {

        $name = $request->input(UserRequestConstants::NAME);
        $email = $request->input(UserRequestConstants::EMAIL);
        $password = $request->input(UserRequestConstants::PASSWORD);
        return response()->json($this->authService->register($name, $email, $password));


    }
    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $email = $request->input(UserRequestConstants::EMAIL);
        $password = $request->input(UserRequestConstants::PASSWORD);
        return response()->json($this->authService->login($email, $password));

    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    // public function refresh()
    // {
    //     return $this->respondWithToken(auth()->refresh());
    // }



}
