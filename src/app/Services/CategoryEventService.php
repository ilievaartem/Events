<?php

namespace App\Services;

use App\Repositories\Interfaces\CategoryEventRepositoryInterface;

class CategoryEventService
{
    public function __construct(private CategoryEventRepositoryInterface $categoryEventRepository)
    {
    }
    public function getEventsIdByCategories(array $categoriesIds): array
    {
        return $this->categoryEventRepository->getEventsIdByCategories($categoriesIds);
    }

}
