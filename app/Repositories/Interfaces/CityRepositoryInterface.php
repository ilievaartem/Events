<?php

namespace App\Repositories\Interfaces;

interface CityRepositoryInterface extends BaseRepositoryInterface
{
    public function getIdByName(string $name): int;
    public function checkIsCityExistByName(string $name): bool;

}
