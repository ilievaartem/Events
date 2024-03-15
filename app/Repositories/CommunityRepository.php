<?php

namespace App\Repositories;

use App\Constants\DB\CommunityDBConstants;
use App\Models\Community;
use App\Repositories\Interfaces\CommunityRepositoryInterface;

class CommunityRepository extends BaseRepository implements CommunityRepositoryInterface
{
    public function RegionCommunities(int $regionId): array
    {
        return Community::query()->where(CommunityDBConstants::REGION_ID, $regionId)->cursorPaginate(self::PER_PAGE)->toArray();
    }
    public function checkIsExistByNameAndRegion(string $name, int $regionId): bool
    {
        return Community::query()->where(CommunityDBConstants::NAME, $name)->where(CommunityDBConstants::REGION_ID, $regionId)->exists();
    }
}
