<?php

namespace App\Services;

use App\Constants\DB\TagDBConstants;
use App\Exceptions\ConflictException;
use App\Exceptions\NotFoundException;
use App\Repositories\BaseRepository;
use App\Repositories\Interfaces\BaseRepositoryInterface;
use App\Repositories\Interfaces\TagRepositoryInterface;
use App\Services\System\CRUDService;

class TagService extends CRUDService
{
    public function __construct( TagRepositoryInterface $repository)
    {
        parent::__construct($repository);
    }
    public function create(string $name): array
    {
        return $this->repository->checkIsExistByName($name)
            ? throw new ConflictException("Tag already exist")
            : $this->repository->create($this->formatNameForRecord($name));
    }
    private function formatNameForRecord(string $name): array
    {
        return [
            TagDBConstants::NAME => $name
        ];
    }
    public function update(string $name, int $id): array
    {
        $this->checkIsExist($id);
        $this->repository->checkIsExistByName($name)
            ? throw new ConflictException("Category already exist")
            : $this->repository->update($this->formatNameForRecord($name), $id);
        return $this->repository->show($id);
    }
    public function index(?array $filter): array
    {
        $index = $this->repository->index();
        if ($index != null) {
            return $index;
        }
        throw new NotFoundException("Tags is not found");
    }
    public function checkIsExist(string $id): void
    {
        if ($this->repository->checkIsExist($id) == false) {
            throw new NotFoundException("Tag is not found");
        }
    }

}
