<?php

namespace App\DTO\Auth;

use App\DTO\Contracts\DTOContract;

class AuthRegisterDTO implements DTOContract
{
    public function __construct(
        private readonly string $name,
        private readonly string $email,
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
    public function getTelephone(): string
    {
        return $this->telephone;
    }
    public function getPassword(): string
    {
        return $this->password;
    }
}
