<?php

namespace App\Repositories;

use App\Models\User;
use App\Constants\Request\UserRequestConstants;

class AuthRepository
{

    public function isUserExist(string $userEmail): bool
    {
        return User::where(UserRequestConstants::EMAIL, $userEmail)->exists();
    }
    public function register(array $user): array
    {
        return User::create($user)->toArray();
    }
}
