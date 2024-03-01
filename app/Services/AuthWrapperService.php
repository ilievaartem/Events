<?php

namespace App\Services;

use App\Constants\Request\UserRequestConstants;
use App\Services\Interfaces\AuthWrapperServiceInterface;

class AuthWrapperService implements AuthWrapperServiceInterface
{
    public function getTTl(): mixed
    {
        return auth()->factory()->getTTL() * 60;
    }
    public function getAuthIdentifier(): mixed
    {
        return auth()->user()->getAuthIdentifier();
    }
    public function makeAttempt(string $email, string $password): mixed
    {
        return auth()->attempt([UserRequestConstants::EMAIL => $email, UserRequestConstants::PASSWORD => $password]);
    }
}
