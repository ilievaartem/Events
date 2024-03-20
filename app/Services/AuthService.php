<?php

namespace App\Services;

use App\Constants\DB\UserDBConstants;
use App\Repositories\AuthRepository;
use Illuminate\Support\Facades\Hash;
use App\Exceptions\AuthException;
use App\Constants\Request\UserRequestConstants;
use App\Constants\Role\UserRoleConstants;
use App\DTO\Auth\AuthRegisterDTO;
use App\Exceptions\ConflictException;
use App\Exceptions\ForbiddenException;
use App\Exceptions\NotFoundException;

class AuthService
{
    public function __construct(
        private readonly AuthRepository $authRepository,
        private readonly AuthWrapperService $authWrapperService
    ) {
    }
    public function login(string $email, string $password): array
    {
        $token = $this->authWrapperService->makeAttempt($email, $password);
        if (!$token) {
            throw new NotFoundException("User is not exist");
        }
        return $this->respondWithToken($token);


    }
    public function loginNewUser(mixed $token): array
    {
        return $this->respondWithToken($token);
    }
    public function logout(): bool
    {
        return $this->authWrapperService->logout();
    }
    private function formatUserForRegister(AuthRegisterDTO $user): array
    {
        return [
            UserDBConstants::NAME => $user->getName(),
            UserDBConstants::EMAIL => $user->getEmail(),
            UserDBConstants::TELEPHONE => $user->getTelephone(),
            UserDBConstants::ROLE => UserRoleConstants::ROLE_USER,
            UserDBConstants::PASSWORD => $user->getPassword(),
        ];
    }
    public function register(AuthRegisterDTO $user)
    {
        $this->authRepository->register($this->formatUserForRegister($user));
        return $this->respondWithToken($this->authWrapperService->makeAttempt($user->getEmail(), $user->getPassword()));
    }
    public function isUserExist(string $email): void
    {
        if ($this->authRepository->isUserExist($email) == false) {
            throw new ConflictException("User is already exist");
        }
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
            'expires_in' => $this->authWrapperService->getTTl()
        ];
    }
}
