<?php

namespace App\Repositories\Interfaces;

interface PlaceRepositoryInterface extends BaseRepositoryInterface
{
    public function CommunityPlaces(int $communityId): array;
    public function checkIsExistByName(string $name): bool;
    public function getGeoByPlace(int $placeId): array;

    public function checkIsExistByNameAndCommunity(string $name, int $communityId): bool;
    public function getPlacesForEvents(): array;
}
