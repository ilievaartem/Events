<?php

namespace App\Services;

use App\Constants\DB\CountryDBConstants;
use App\Exceptions\ConflictException;
use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\CountryRepositoryInterface;

class CountryService
{
    public function __construct(private CountryRepositoryInterface $countryRepository)
    {
    }
    public function index(): array
    {
        return $this->countryRepository->index();
    }
    public function show(int $id): array
    {
        $this->checkIsExist($id);
        return $this->countryRepository->show($id);
    }
    public function create(string $name): array
    {
        return $this->countryRepository->checkIsExistByName($name)
            ? throw new ConflictException("Country already exist")
            : $this->countryRepository->create($this->formatNameForDB($name));
    }
    public function delete(int $id): bool
    {
        return $this->countryRepository->delete($id);
    }
    private function formatNameForDB(string $name): array
    {
        return [CountryDBConstants::NAME => $name];
    }
    public function update(string $name, int $id): array
    {
        $this->checkIsExist($id);
        $this->countryRepository->checkIsExistByName($name)
            ? throw new ConflictException("Country already exist")
            : $this->countryRepository->update($this->formatNameForDB($name), $id);
        return $this->countryRepository->show($id);
    }
    public function checkIsExist(string $id): void
    {
        if ($this->countryRepository->checkIsExist($id) == false) {
            throw new NotFoundException("Country is not found");

        }
    }

}
