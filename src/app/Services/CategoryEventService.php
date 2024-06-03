<?php

namespace App\Services;

use App\Repositories\Interfaces\CategoryEventRepositoryInterface;

class CategoryEventService
{
    public function __construct(private readonly CategoryEventRepositoryInterface $categoryEventRepository)
    {
    }

    /**
     * @param array $categoriesIds
     * @return array
     */
    public function getEventsIdByCategories(array $categoriesIds): array
    {
        return $this->categoryEventRepository->getEventsIdByCategories($categoriesIds);
    }

    /**
     * @param int $year
     * @param array $months
     * @return array
     */
    public function getCategoriesCountsByYearAndMonths(int $year,array $months): array
    {
        return $this->categoryEventRepository->getCategoriesCountsByYearAndMonths($year, $months);
    }

}
