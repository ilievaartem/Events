<?php

namespace App\Services;

use App\Constants\DB\PlaceDBConstants;
use App\DTO\Place\CreatePlaceDTO;
use App\DTO\Place\UpdatePlaceDTO;
use App\Exceptions\ConflictException;
use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\Repositories\Interfaces\PlaceRepositoryInterface;
use App\Services\System\CRUDService;

class PlaceService extends CRUDService
{
    public function __construct(
        PlaceRepositoryInterface $repository,
        private readonly CommunityService         $communityService,
    )
    {
        parent::__construct($repository);
    }

    /**
     * @param int $communityId
     * @return array
     * @throws NotFoundException
     */
    public function communityPlaces(int $communityId): array
    {
        $this->communityService->checkIsExist($communityId);
        return $this->repository->CommunityPlaces($communityId);
    }

    /**
     * @return array
     */
    public function showEventEdit(): array
    {
        return $this->repository->getPlacesForEvents();
    }

    /**
     * @param CreatePlaceDTO $createPlaceDTO
     * @return array
     * @throws ConflictException
     * @throws NotFoundException
     */
    public function create(CreatePlaceDTO $createPlaceDTO): array
    {
        $this->communityService->checkIsExist($createPlaceDTO->getCommunityId());
        if ($this->repository->checkIsExistByNameAndCommunity($createPlaceDTO->getName(), $createPlaceDTO->getCommunityId())) {
            throw new ConflictException("Place already exist");
        }
        return $this->repository->create($this->formatForDBCreate($createPlaceDTO));
    }

    /**
     * @param CreatePlaceDTO $createPlaceDTO
     * @return array
     */
    private function formatForDBCreate(CreatePlaceDTO $createPlaceDTO): array
    {
        return [
            PlaceDBConstants::NAME => $createPlaceDTO->getName(),
            PlaceDBConstants::COMMUNITY_ID => $createPlaceDTO->getCommunityId(),
            PlaceDBConstants::TYPE => $createPlaceDTO->getType()
        ];
    }

    /**
     * @param UpdatePlaceDTO $updatePlaceDTO
     * @return array
     */
    private function formatForDBUpdate(UpdatePlaceDTO $updatePlaceDTO): array
    {
        return [
            PlaceDBConstants::NAME => $updatePlaceDTO->getName(),
            PlaceDBConstants::TYPE => $updatePlaceDTO->getType()
        ];
    }

    /**
     * @param UpdatePlaceDTO $updatePlaceDTO
     * @return array
     * @throws ConflictException
     * @throws NotFoundException
     */
    public function update(UpdatePlaceDTO $updatePlaceDTO): array
    {
        $this->communityService->checkIsExist($updatePlaceDTO->getCommunityId());
        $this->checkIsExist($updatePlaceDTO->getId());
        if ($this->repository->checkIsExistByNameAndCommunity($updatePlaceDTO->getName(), $updatePlaceDTO->getCommunityId())) {
            throw new ConflictException("Place already exist");
        }
        $this->repository->update($this->formatForDBUpdate($updatePlaceDTO), $updatePlaceDTO->getId());
        return $this->repository->show($updatePlaceDTO->getId());
    }

    /**
     * @return string
     */
    public function getPlaceTypeList(): string
    {
        return PlaceDBConstants::TYPE_VILLAGE . ',' . PlaceDBConstants::TYPE_CITY . ','
            . PlaceDBConstants::TYPE_URBAN_VILLAGE . ',' . PlaceDBConstants::TYPE_SMALL_VILLAGE;
    }

    /**
     * @throws NotFoundException
     */
    public function checkIsExistByName(string $name): void
    {
        if (!$this->repository->checkIsExistByName($name)) {
            throw new NotFoundException("Place is not found");
        }
    }

    /**
     * @param int $placeId
     * @return array
     */
    public function getGeoByPlace(int $placeId): array
    {
        return $this->repository->getGeoByPlace($placeId);
    }

    /**
     * @throws NotFoundException
     */
    public function checkIsExist(string $id): void
    {
        if (!$this->repository->checkIsExist($id)) {
            throw new NotFoundException("Place is not found");

        }
    }
}
