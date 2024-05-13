<?php

namespace App\Repositories\Interfaces;

interface BaseRepositoryInterface
{
    public function create(array $data): array;

    public function insert(array $data): bool;

    public function checkIsExist(int|string $id): bool;

    public function update(array $data, int|string $id): bool;

    public function delete(int|string $id): bool;

    public function show(int|string $id): array;

    public function index(?array $filter): array;

    public function getAll(?string $orderFieldName, ?string $directionName);
}
