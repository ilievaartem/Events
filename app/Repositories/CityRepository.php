<?php

namespace App\Repositories;

use App\Constants\DB\CityDBConstants;
use App\Models\City;
use App\Repositories\Interfaces\CityRepositoryInterface;

class CityRepository extends BaseRepository implements CityRepositoryInterface
{
    public function getIdByName(string $name): int
    {
        return City::query()->where(CityDBConstants::NAME, $name)->first()->id;
    }
    public function checkIsCityExistByName(string $name): bool
    {
        return City::query()->where(CityDBConstants::NAME, $name)->exists();
    }
}
