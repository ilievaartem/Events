<?php

namespace App\Repositories;

use App\Constants\DB\PlaceDBConstants;
use App\Models\Place;
use App\Repositories\Interfaces\PlaceRepositoryInterface;

class PlaceRepository extends BaseRepository implements PlaceRepositoryInterface
{

    public function CommunityPlaces(int $communityId): array
    {
        return Place::query()->where(PlaceDBConstants::COMMUNITY_ID, $communityId)->cursorPaginate(self::PER_PAGE)->toArray();
    }
    public function checkIsExistByNameAndCommunity(string $name, int $communityId): bool
    {
        return Place::query()->where(PlaceDBConstants::NAME, $name)->where(PlaceDBConstants::COMMUNITY_ID, $communityId)->exists();
    }

    public function checkIsExistByName(string $name): bool
    {
        return Place::query()->where(PlaceDBConstants::NAME, $name)->exists();
    }
}
