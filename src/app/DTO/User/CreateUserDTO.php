<?php

namespace App\DTO\User;

use App\DTO\Contracts\DTOContract;

class CreateUserDTO implements DTOContract
{

    public function __construct(
        private readonly string $name,
        private readonly string $email,
        private readonly string $role,
        private readonly string $telephone,
        private readonly string $password,
    ) {
    }
    public function getName(): string
    {
        return $this->name;
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
    public function getPassword(): string
    {
        return $this->password;
    }
}
