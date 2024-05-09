<?php

namespace App\Repositories\Interfaces;

interface CountryRepositoryInterface extends BaseRepositoryInterface
{
    public function checkIsExistByName(string $name): bool;
}
