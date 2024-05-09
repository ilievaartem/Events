<?php

namespace App\Repositories;

use App\Constants\DB\CountryDBConstants;
use App\Repositories\Interfaces\CountryRepositoryInterface;

class CountryRepository extends BaseRepository implements CountryRepositoryInterface
{
    public function checkIsExistByName(string $name): bool
    {
        return $this->model->query()->where(CountryDBConstants::NAME, $name)->exist();
    }
}
