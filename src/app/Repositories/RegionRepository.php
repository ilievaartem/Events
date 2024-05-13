<?php

namespace App\Repositories;

use App\Constants\DB\RegionDBConstants;
use App\Models\Region;
use App\Repositories\Interfaces\RegionRepositoryInterface;

class RegionRepository extends BaseRepository implements RegionRepositoryInterface
{
    public function index(?array $filter): array
    {
        return $this->model->query()
            ->when(!empty($filter['search']), function ($q) use ($filter) {
                return $q->where(function ($q) use ($filter) {
                    $q->where('name', 'like', '%' . trim($filter['search']) . '%');
                });
            })
            ->when((!empty($filter['field']) && !empty($filter['direction'])), function ($q) use ($filter) {
                return $q->orderBy($filter['field'], $filter['direction']);
            })
            ->with('country')
            ->paginate()->toArray();
    }

    public function countryRegions(int $countryId): array
    {
        return $this->model->query()->where(RegionDBConstants::COUNTRY_ID, $countryId)->cursorPaginate(self::PER_PAGE)->toArray();
    }

    public function checkIsExistByNameAndCountry(string $name, int $countryId): bool
    {
        return $this->model->query()->where(RegionDBConstants::NAME, $name)->where(RegionDBConstants::COUNTRY_ID, $countryId)->exists();
    }
}
