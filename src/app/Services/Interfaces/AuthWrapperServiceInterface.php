<?php

namespace App\Services\Interfaces;

interface AuthWrapperServiceInterface
{
    public function getTTl(): mixed;

    public function makeAttempt(string $email, string $password): mixed;
    public function getAuthIdentifier(): mixed;


}
