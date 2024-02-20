<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryService
{
    public function __construct(private CategoryRepositoryInterface $categoryRepository)
    {

    }
    public function create(array $data): array
    {
        return $this->categoryRepository->create($data);
    }
    public function index(): array
    {
        $index = $this->categoryRepository->index();
        if ($index != null) {
            return $index;
        }
        throw new NotFoundException("Categories is not found");
    }
    public function show(int $id): ?array
    {
        $show = $this->categoryRepository->show($id);
        if ($show != null) {
            return $show;
        }
        throw new NotFoundException("Category is not found");
    }
    public function delete(int $id): bool
    {
        return $this->categoryRepository->delete($id);
    }
    public function update(array $data, int $id): array
    {
        $this->categoryRepository->update($data, $id);
        return $this->categoryRepository->show($id);
    }
}
