<?php

namespace App\DTO\User;

use App\DTO\Contracts\DTOContract;

class UpdateUserDTO implements DTOContract
{

    public function __construct(
        private readonly string $name,
        private readonly string $userId,
        private readonly string $email,
        private readonly string $telephone,
        private readonly string $password,
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

    public function getTelephone(): string
    {
        return $this->telephone;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
}
