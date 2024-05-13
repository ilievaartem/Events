<?php

namespace App\Services;

use App\Constants\DB\CommonDB\CommonDBConstants;
use App\Constants\DB\CountryDBConstants;
use App\Constants\DB\RegionDBConstants;
use App\Exceptions\ConflictException;
use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\RegionRepositoryInterface;
use App\Repositories\RegionRepository;
use App\Services\System\CRUDService;

class RegionService extends CRUDService
{
    public function __construct(
        RegionRepositoryInterface       $repository,
        private readonly CountryService $countryService,
    )
    {
        /** @var RegionRepository $repository */
        $this->repository = $repository;
        parent::__construct($repository);
    }

    /**
     * @return array
     */
    public function getTable(): array
    {
        $countries = $this->countryService->getAll(CountryDBConstants::NAME, CommonDBConstants::SORTING_DIRECTION_DEFAULT);

        return ['countries' => $countries];
    }

    /**
     * @param int $countryId
     * @return array
     * @throws NotFoundException
     */
    public function countryRegions(int $countryId): array
    {
        $this->countryService->checkIsExist($countryId);

        return $this->repository->countryRegions($countryId);
    }

    /**
     * @param string $name
     * @param int $countryId
     * @return array
     * @throws ConflictException
     * @throws NotFoundException
     */
    public function create(string $name, int $countryId): array
    {
        $this->countryService->checkIsExist($countryId);
        return $this->repository->checkIsExistByNameAndCountry($name, $countryId)
            ? throw new ConflictException("Region already exist")
            : $this->repository->create($this->formatForDBCreate($name, $countryId));
    }

    /**
     * @param string $name
     * @param int $countryId
     * @return array
     */
    private function formatForDBCreate(string $name, int $countryId): array
    {
        return [
            RegionDBConstants::NAME => $name,
            RegionDBConstants::COUNTRY_ID => $countryId
        ];
    }

    /**
     * @param string $name
     * @param int $countryId
     * @return array
     */
    private function formatForDBUpdate(string $name, int $countryId): array
    {
        return [
            RegionDBConstants::NAME => $name,
            RegionDBConstants::COUNTRY_ID => $countryId
        ];

    }

    /**
     * @param int $regionId
     * @param string $name
     * @param int $countryId
     * @return array
     * @throws ConflictException
     * @throws NotFoundException
     */
    public function update(int $regionId, string $name, int $countryId): array
    {
        $this->checkIsExist($regionId);
        $this->countryService->checkIsExist($countryId);
        $this->repository->checkIsExistByNameAndCountry($name, $countryId)
            ? throw new ConflictException("Region already exist")
            : $this->repository->update($this->formatForDBUpdate($name, $countryId), $regionId);
        return $this->repository->show($regionId);
    }

    /**
     * @param string $id
     * @return void
     * @throws NotFoundException
     */
    public function checkIsExist(string $id): void
    {
        if (!$this->repository->checkIsExist($id)) {
            throw new NotFoundException("Region is not found");

        }
    }
}
