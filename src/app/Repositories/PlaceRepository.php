<?php

namespace App\Repositories;

use App\Constants\DB\CommunityDBConstants;
use App\Constants\DB\CountryDBConstants;
use App\Constants\DB\PlaceDBConstants;
use App\Constants\DB\RegionDBConstants;
use App\Models\Place;
use App\Repositories\Interfaces\PlaceRepositoryInterface;

class PlaceRepository extends BaseRepository implements PlaceRepositoryInterface
{

    public function getGeoByPlace(int $placeId): array
    {
        return Place::query()
            ->join(
                CommunityDBConstants::TABLE,
                PlaceDBConstants::TABLE . '.' . PlaceDBConstants::COMMUNITY_ID,
                '=',
                CommunityDBConstants::TABLE . '.' . CommunityDBConstants::ID
            )
            ->join(
                RegionDBConstants::TABLE,
                RegionDBConstants::TABLE . '.' . RegionDBConstants::ID,
                '=',
                CommunityDBConstants::TABLE . '.' . CommunityDBConstants::REGION_ID
            )
            ->join(
                CountryDBConstants::TABLE,
                CountryDBConstants::TABLE . '.' . CountryDBConstants::ID,
                '=',
                RegionDBConstants::TABLE . '.' . RegionDBConstants::COUNTRY_ID
            )
            ->select(
                CountryDBConstants::TABLE . '.' . CountryDBConstants::ID . ' as ' . RegionDBConstants::COUNTRY_ID,
                RegionDBConstants::TABLE . '.' . RegionDBConstants::ID . ' as ' . CommunityDBConstants::REGION_ID,
                CommunityDBConstants::TABLE . '.' . CommunityDBConstants::ID . ' as ' . PlaceDBConstants::COMMUNITY_ID,
                PlaceDBConstants::TABLE . '.' . PlaceDBConstants::ID . ' as place_id'
            )
            ->where(PlaceDBConstants::TABLE . '.' . PlaceDBConstants::ID, $placeId)
            ->first()->toArray();
    }
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
