<?php

namespace App\Services;

use App\Constants\DB\CityDBConstants;
use App\Exceptions\BadRequestException;
use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\CityRepositoryInterface;

class CityService
{
    public function __construct(private CityRepositoryInterface $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }
    public function index(): array
    {
        $index = $this->cityRepository->index();
        if ($index != null) {
            return $index;
        }
        throw new NotFoundException("Cities are not found");
    }
    public function show(int $id): ?array
    {
        $this->checkIsExist($id);

        return $this->cityRepository->show($id);
    }
    public function create(string $countryId, string $name): array
    {
        $city = [
            CityDBConstants::NAME => $name,
            CityDBConstants::COUNTRY_ID => $countryId
        ];
        return $this->cityRepository->create($city);
    }
    public function delete(int $id): bool
    {
        return $this->cityRepository->delete($id);
    }
    public function checkIsCityExistByName(string $name): void
    {
        if ($this->cityRepository->checkIsCityExistByName($name) == false) {
            throw new BadRequestException('Unknow city in records');
        }
    }
    public function getIdByName(string $name): int
    {
        $this->checkIsCityExistByName($name);
        return $this->cityRepository->getIdByName($name);
    }
    public function update(array $data, int $id): array
    {
        $this->checkIsExist($id);

        $this->cityRepository->update($data, $id);
        return $this->cityRepository->show($id);
    }
    public function checkIsExist(string $id): void
    {
        if ($this->cityRepository->checkIsExist($id) == false) {
            throw new NotFoundException("City is not found");

        }
    }
}
