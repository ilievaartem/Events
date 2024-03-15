<?php

namespace App\Repositories\Interfaces;

interface RegionRepositoryInterface extends BaseRepositoryInterface
{
    public function CountryRegions(int $countryId): array;
    public function checkIsExistByNameAndCountry(string $name, int $countryId): bool;
}
