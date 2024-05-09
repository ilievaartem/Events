<?php

namespace App\Services;

use App\Constants\DB\RegionDBConstants;
use App\Exceptions\ConflictException;
use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\RegionRepositoryInterface;

class RegionService
{
    public function __construct(
        private RegionRepositoryInterface $regionRepository,
        private CountryService $countryService,
    ) {
    }
    public function CountryRegions(int $countryId): array
    {
        $this->countryService->checkIsExist($countryId);
        return $this->regionRepository->CountryRegions($countryId);
    }
    public function show(int $id): array
    {
        $this->checkIsExist($id);
        return $this->regionRepository->show($id);
    }
    public function create(string $name, int $countryId): array
    {
        $this->countryService->checkIsExist($countryId);
        return $this->regionRepository->checkIsExistByNameAndCountry($name, $countryId)
            ? throw new ConflictException("Region already exist")
            : $this->regionRepository->create($this->formatForDBCreate($name, $countryId));
    }
    private function formatForDBCreate(string $name, int $countryId): array
    {
        return [
            RegionDBConstants::NAME => $name,
            RegionDBConstants::COUNTRY_ID => $countryId
        ];
    }
    private function formatForDBUpdate(string $name): array
    {
        return [RegionDBConstants::NAME => $name];
    }
    public function update(int $regionId, string $name, int $countryId): array
    {
        $this->checkIsExist($regionId);
        $this->countryService->checkIsExist($countryId);
        $this->regionRepository->checkIsExistByNameAndCountry($name, $countryId)
            ? throw new ConflictException("Region already exist")
            : $this->regionRepository->update($this->formatForDBUpdate($name), $regionId);
        return $this->regionRepository->show($regionId);
    }
    public function delete(int $id): bool
    {
        return $this->regionRepository->delete($id);
    }
    public function checkIsExist(string $id): void
    {
        if ($this->regionRepository->checkIsExist($id) == false) {
            throw new NotFoundException("Region is not found");

        }
    }
}
