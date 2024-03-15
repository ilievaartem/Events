<?php

namespace App\Repositories\Interfaces;

interface PlaceRepositoryInterface extends BaseRepositoryInterface
{
    public function CommunityPlaces(int $communityId): array;
    public function checkIsExistByNameAndCommunity(string $name, int $communityId): bool;

}
