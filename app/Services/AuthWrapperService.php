<?php

namespace App\Services;

use App\Constants\Request\UserRequestConstants;
use App\Exceptions\ConflictException;
use App\Services\Interfaces\AuthWrapperServiceInterface;
use Exception;

class AuthWrapperService implements AuthWrapperServiceInterface
{
    public function getTTl(): mixed
    {
        return auth()->factory()->getTTL() * 60;
    }
    public function getAuthIdentifier(): mixed
    {
        if (auth()->user() === null) {
            throw new ConflictException('Token time is run out');
        }
        return auth()->user()->getAuthIdentifier();
    }
    public function makeAttempt(string $email, string $password): mixed
    {
        return auth()->attempt([UserRequestConstants::EMAIL => $email, UserRequestConstants::PASSWORD => $password]);
    }
}
