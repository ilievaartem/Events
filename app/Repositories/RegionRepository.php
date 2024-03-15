<?php

namespace App\Repositories;

use App\Constants\DB\RegionDBConstants;
use App\Models\Region;
use App\Repositories\Interfaces\RegionRepositoryInterface;

class RegionRepository extends BaseRepository implements RegionRepositoryInterface
{
    public function CountryRegions(int $countryId): array
    {
        return Region::query()->where(RegionDBConstants::COUNTRY_ID, $countryId)->cursorPaginate(self::PER_PAGE)->toArray();
    }
    public function checkIsExistByNameAndCountry(string $name, int $countryId): bool
    {
        return Region::query()->where(RegionDBConstants::NAME, $name)->where(RegionDBConstants::COUNTRY_ID, $countryId)->exists();
    }
}
