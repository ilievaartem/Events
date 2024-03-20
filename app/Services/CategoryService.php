<?php

namespace App\Services;

use App\Constants\DB\CategoryDBConstants;
use App\Exceptions\ConflictException;
use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryService
{
    public function __construct(private CategoryRepositoryInterface $categoryRepository)
    {
    }
    public function create(string $name, ?int $parentId): array
    {
        $this->categoryRepository->checkIsExist($parentId);
        return $this->categoryRepository->checkIsExistByName($name)
            ? throw new ConflictException("Category already exist")
            : $this->categoryRepository->create($this->formatForCreate($name, $parentId));
    }
    private function formatForCreate(string $name, ?int $parentId): array
    {
        return [
            CategoryDBConstants::NAME => $name,
            CategoryDBConstants::PARENT_ID => $parentId
        ];
    }
    public function index(): array
    {
        $index = $this->categoryRepository->index();
        if ($index != null) {
            return $index;
        }
        throw new NotFoundException("Categories is not found");
    }
    public function show(int $id): array
    {
        $this->checkIsExist($id);
        return $this->categoryRepository->show($id);
    }
    public function getCategoryChild(int $parentId): array
    {
        $this->checkIsExist($parentId);
        return $this->categoryRepository->getCategoryChild($parentId);
    }
    public function delete(int $id): bool
    {
        return $this->categoryRepository->delete($id);
    }
    private function formatForUpdate(string $name): array
    {
        return [
            CategoryDBConstants::NAME => $name
        ];
    }
    public function update(string $name, int $id): array
    {
        $this->checkIsExist($id);
        $this->categoryRepository->checkIsExistByName($name)
            ? throw new ConflictException("Category already exist")
            : $this->categoryRepository->update($this->formatForUpdate($name), $id);
        return $this->categoryRepository->show($id);
    }
    public function checkIsExist(string $id): void
    {
        if ($this->categoryRepository->checkIsExist($id) == false) {
            throw new NotFoundException("Category is not found");
        }
    }
}
