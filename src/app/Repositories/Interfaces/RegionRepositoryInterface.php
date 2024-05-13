<?php

namespace App\Repositories\Interfaces;

interface RegionRepositoryInterface extends BaseRepositoryInterface
{
    public function countryRegions(int $countryId): array;
    public function checkIsExistByNameAndCountry(string $name, int $countryId): bool;
    public function index(?array $filter): array;
}
