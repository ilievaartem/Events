<?php

namespace App\Repositories\Interfaces;

interface PlaceRepositoryInterface extends BaseRepositoryInterface
{
    public function CommunityPlaces(int $communityId): array;
    public function checkIsExistByName(string $name): bool;

    public function checkIsExistByNameAndCommunity(string $name, int $communityId): bool;
}
