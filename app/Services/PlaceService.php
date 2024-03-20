<?php

namespace App\Services;

use App\Constants\DB\PlaceDBConstants;
use App\Exceptions\ConflictException;
use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\PlaceRepositoryInterface;

class PlaceService
{
    public function __construct(
        private PlaceRepositoryInterface $placeRepository,
        private CommunityService $communityService,
    ) {
    }
    public function CommunityPlaces(int $communityId): array
    {
        $this->communityService->checkIsExist($communityId);
        return $this->placeRepository->CommunityPlaces($communityId);
    }
    public function show(int $id): array
    {
        $this->checkIsExist($id);
        return $this->placeRepository->show($id);
    }
    public function create(string $name, string $type, int $communityId): array
    {
        $this->communityService->checkIsExist($communityId);
        return $this->placeRepository->checkIsExistByNameAndCommunity($name, $communityId)
            ? throw new ConflictException("Place already exist")
            : $this->placeRepository->create($this->formatForDBCreate($name, $type, $communityId));
    }
    private function formatForDBCreate(string $name, string $type, int $communityId): array
    {
        return [
            PlaceDBConstants::NAME => $name,
            PlaceDBConstants::COMMUNITY_ID => $communityId,
            PlaceDBConstants::TYPE => $type
        ];
    }
    private function formatForDBUpdate(string $name, string $type): array
    {
        return [
            PlaceDBConstants::NAME => $name,
            PlaceDBConstants::TYPE => $type
        ];
    }
    public function update(int $placeId, string $name, string $type, int $communityId): array
    {
        $this->communityService->checkIsExist($communityId);
        $this->checkIsExist($placeId);
        $this->placeRepository->checkIsExistByNameAndCommunity($name, $communityId)
            ? throw new ConflictException("Place already exist")
            : $this->placeRepository->update($this->formatForDBUpdate($name, $type), $placeId);
        return $this->placeRepository->show($placeId);
    }
    public function getPlaceTypeList(): string
    {
        return PlaceDBConstants::TYPE_VILLAGE . ',' . PlaceDBConstants::TYPE_CITY . ','
            . PlaceDBConstants::TYPE_URBAN_VILLAGE . ',' . PlaceDBConstants::TYPE_SMALL_VILLAGE;
    }
    public function checkIsExistByName(string $name): void
    {
        if ($this->placeRepository->checkIsExistByName($name) == false) {
            throw new NotFoundException("Place is not found");
        }
    }
    public function delete(int $id): bool
    {
        return $this->placeRepository->delete($id);
    }
    public function getGeoByPlace(int $placeId): array
    {
        return $this->placeRepository->getGeoByPlace($placeId);
    }
    public function checkIsExist(string $id): void
    {
        if ($this->placeRepository->checkIsExist($id) == false) {
            throw new NotFoundException("Place is not found");

        }
    }
}
