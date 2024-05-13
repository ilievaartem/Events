<?php

namespace App\Repositories\Interfaces;

interface CategoryRepositoryInterface extends BaseRepositoryInterface
{
    public function getCategoryChild(int $parentId): array;
    public function checkIsExistByName(string $name): bool;
    public function index(?array $filter): array;
}
