<?php

namespace App\Services;

use App\Constants\DB\CategoryDBConstants;
use App\Constants\DB\CommonDB\CommonDBConstants;
use App\Exceptions\ConflictException;
use App\Exceptions\NotFoundException;
use App\Repositories\CategoryRepository;
use App\Repositories\Interfaces\CategoryRepositoryInterface;
use App\Services\System\CRUDService;

class CategoryService extends CRUDService
{
    public function __construct(CategoryRepositoryInterface $repository)
    {
        /** @var CategoryRepository $repository */
        $this->repository = $repository;
        parent::__construct($repository);
    }

    /**
     * @return array
     */
    public function getTable()
    {
        $categories = $this->repository->getAll(CategoryDBConstants::NAME, CommonDBConstants::SORTING_DIRECTION_DEFAULT);

        return [
            'categories' => $categories,
        ];
    }

    /**
     * @param string $name
     * @param int|null $parentId
     * @return array
     * @throws ConflictException
     */
    public function create(string $name, ?int $parentId): array
    {
        $this->repository->checkIsExist($parentId);
        return $this->repository->checkIsExistByName($name)
            ? throw new ConflictException("Category already exist")
            : $this->repository->create($this->formatForCreate($name, $parentId));
    }

    /**
     * @param string $name
     * @param int|null $parentId
     * @return array
     */
    private function formatForCreate(string $name, ?int $parentId): array
    {
        return [
            CategoryDBConstants::NAME => $name,
            CategoryDBConstants::PARENT_ID => $parentId
        ];
    }

    /**
     * @param int $parentId
     * @return array
     * @throws NotFoundException
     */
    public function getCategoryChild(int $parentId): array
    {
        $this->checkIsExist($parentId);
        return $this->repository->getCategoryChild($parentId);
    }

    /**
     * @param string $name
     * @param int|null $parentId
     * @return array
     */
    private function formatForUpdate(string $name, ?int $parentId): array
    {
        return [
            CategoryDBConstants::NAME => $name,
            CategoryDBConstants::PARENT_ID => $parentId
        ];
    }

    /**
     * @param string $name
     * @param int|null $parentId
     * @param int $id
     * @return array
     * @throws ConflictException
     * @throws NotFoundException
     */
    public function update(string $name, ?int $parentId, int $id): array
    {
        $this->checkIsExist($id);
        $this->repository->checkIsExistByName($name)
            ? throw new ConflictException("Category already exist")
            : $this->repository->update($this->formatForUpdate($name, $parentId), $id);
        return $this->repository->show($id);
    }

    /**
     * @param string $id
     * @return void
     * @throws NotFoundException
     */
    public function checkIsExist(string $id): void
    {
        if (!$this->repository->checkIsExist($id)) {
            throw new NotFoundException("Category is not found");
        }
    }
}
