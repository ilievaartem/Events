<?php

namespace App\Services;

use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\AuthException;
use App\Constants\Request\UserRequestConstants;
use App\Constants\Role\UserRoleConstants;



class AuthService
{
    public function __construct(
        private readonly AuthRepository $authRepository,
        private readonly AuthWrapperService $authWrapperService
    ) {
    }
    public function login(string $email, string $password): array
    {
        if ($token = $this->authWrapperService->makeAttempt($email, $password)) {
            return $this->respondWithToken($token);
        }
        throw new AuthException("User is not authorize");

    }
    public function loginNewUser($token)
    {
        return $this->respondWithToken($token);
    }
    public function register(string $username, string $email, string $password)
    {

        if (!$this->authRepository->isUserExist($email)) {
            $user = [
                UserRequestConstants::NAME => $username,
                UserRequestConstants::EMAIL => $email,
                UserRequestConstants::ROLE => UserRoleConstants::ROLE_USER,
                UserRequestConstants::PASSWORD => $password,
            ];
            $this->authRepository->register($user);
            return $this->respondWithToken($this->authWrapperService->makeAttempt($email, $password));

        }
        throw new AuthException("User is already registered ");

    }


    /**
     * @param string $token
     *
     * @return array
     */
    private function respondWithToken(string $token): array
    {
        return [
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ];
    }
}
