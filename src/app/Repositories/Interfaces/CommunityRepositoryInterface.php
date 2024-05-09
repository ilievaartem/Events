<?php

namespace App\Repositories\Interfaces;

interface CommunityRepositoryInterface extends BaseRepositoryInterface
{
    public function RegionCommunities(int $regionId): array;
    public function checkIsExistByNameAndRegion(string $name, int $regionId): bool;
}
