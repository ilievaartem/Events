<?php

namespace App\Services\System;

use App\Repositories\Interfaces\BaseRepositoryInterface;

abstract class CRUDService
{
    public function __construct(protected BaseRepositoryInterface $repository)
    {

    }

    /**
     * @param array|null $filter
     * @return array
     */
    public function index(?array $filter): array
    {
        return $this->repository->index($filter);
    }

    /**
     * @param string|null $orderFieldName
     * @param string|null $directionName
     * @return array
     */
    public function getAll(?string $orderFieldName, ?string $directionName): array
    {
        return $this->repository->getAll($orderFieldName, $directionName);
    }

    /**
     * @param int|string $id
     * @return array|null
     */
    public function show(int|string $id): ?array
    {
        $this->checkIsExist($id);
        return $this->repository->show($id);
    }

    /**
     * @param int|string $id
     * @return bool
     */
    public function delete(int|string $id): bool
    {
        return $this->repository->delete($id);
    }
}
