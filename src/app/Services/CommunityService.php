<?php

namespace App\Services;

use App\Constants\DB\CommunityDBConstants;
use App\Exceptions\ConflictException;
use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\Repositories\Interfaces\CommunityRepositoryInterface;
use App\Services\System\CRUDService;

class CommunityService extends CRUDService
{
    public function __construct(
        CommunityRepositoryInterface $repository,
        private readonly RegionService $regionService,
    ) {
        parent::__construct($repository);
    }
    public function RegionCommunities(int $regionId): array
    {
        $this->regionService->checkIsExist($regionId);
        return $this->repository->RegionCommunities($regionId);
    }
    public function create(string $name, int $regionId): array
    {
        $this->regionService->checkIsExist($regionId);
        return $this->repository->checkIsExistByNameAndRegion($name, $regionId)
            ? throw new ConflictException("Community already exist")
            : $this->repository->create($this->formatForDBCreate($name, $regionId));
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
        $this->repository->checkIsExistByNameAndRegion($name, $regionId)
            ? throw new ConflictException("Community already exist")
            : $this->repository->update($this->formatForDBUpdate($name), $communityId);
        return $this->repository->show($communityId);
    }
    public function checkIsExist(string $id): void
    {
        if ($this->repository->checkIsExist($id) == false) {
            throw new NotFoundException("Community is not found");

        }
    }
}
