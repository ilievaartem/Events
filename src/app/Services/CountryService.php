<?php

namespace App\Services;

use App\Constants\DB\CountryDBConstants;
use App\Exceptions\ConflictException;
use App\Exceptions\NotFoundException;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\Repositories\Interfaces\CountryRepositoryInterface;
use App\Services\System\CRUDService;

class CountryService extends CRUDService
{
    public function __construct( CountryRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
    public function create(string $name): array
    {
        return $this->repository->checkIsExistByName($name)
            ? throw new ConflictException("Country already exist")
            : $this->repository->create($this->formatNameForDB($name));
    }
    private function formatNameForDB(string $name): array
    {
        return [CountryDBConstants::NAME => $name];
    }
    public function update(string $name, int $id): array
    {
        $this->checkIsExist($id);
        $this->repository->checkIsExistByName($name)
            ? throw new ConflictException("Country already exist")
            : $this->repository->update($this->formatNameForDB($name), $id);
        return $this->repository->show($id);
    }
    public function checkIsExist(string $id): void
    {
        if ($this->repository->checkIsExist($id) == false) {
            throw new NotFoundException("Country is not found");

        }
    }

}
