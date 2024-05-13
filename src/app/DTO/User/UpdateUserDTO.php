<?php

namespace App\DTO\User;

use App\DTO\Contracts\DTOContract;

class UpdateUserDTO implements DTOContract
{

    public function __construct(
        private readonly string $name,
        private readonly string $userId,
        private readonly string $email,
        private readonly string $role,
        private readonly string $telephone,
    ) {
    }
    public function getName(): string
    {
        return $this->name;
    }
    public function getUserId(): string
    {
        return $this->userId;
    }
    public function getEmail(): string
    {
        return $this->email;
    }
    public function getRole(): string
    {
        return $this->role;
    }
    public function getTelephone(): string
    {
        return $this->telephone;
    }
}
