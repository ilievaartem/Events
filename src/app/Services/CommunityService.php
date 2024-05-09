<?php

namespace App\Services;

use App\Constants\DB\CommunityDBConstants;
use App\Exceptions\ConflictException;
use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\CommunityRepositoryInterface;

class CommunityService
{
    public function __construct(
        private CommunityRepositoryInterface $communityRepository,
        private RegionService $regionService,
    ) {
    }
    public function RegionCommunities(int $regionId): array
    {
        $this->regionService->checkIsExist($regionId);
        return $this->communityRepository->RegionCommunities($regionId);
    }
    public function show(int $id): array
    {
        $this->checkIsExist($id);
        return $this->communityRepository->show($id);
    }
    public function create(string $name, int $regionId): array
    {
        $this->regionService->checkIsExist($regionId);
        return $this->communityRepository->checkIsExistByNameAndRegion($name, $regionId)
            ? throw new ConflictException("Community already exist")
            : $this->communityRepository->create($this->formatForDBCreate($name, $regionId));
    }
    private function formatForDBCreate(string $name, int $regionId): array
    {
        return [
            CommunityDBConstants::NAME => $name,
            CommunityDBConstants::REGION_ID => $regionId
        ];
    }
    private function formatForDBUpdate(string $name): array
    {
        return [CommunityDBConstants::NAME => $name];
    }
    public function update(int $communityId, string $name, int $regionId): array
    {
        $this->regionService->checkIsExist($regionId);
        $this->checkIsExist($communityId);
        $this->communityRepository->checkIsExistByNameAndRegion($name, $regionId)
            ? throw new ConflictException("Community already exist")
            : $this->communityRepository->update($this->formatForDBUpdate($name), $communityId);
        return $this->communityRepository->show($communityId);
    }
    public function delete(int $id): bool
    {
        return $this->communityRepository->delete($id);
    }
    public function checkIsExist(string $id): void
    {
        if ($this->communityRepository->checkIsExist($id) == false) {
            throw new NotFoundException("Community is not found");

        }
    }
}
