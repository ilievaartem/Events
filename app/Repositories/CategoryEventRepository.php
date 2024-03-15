<?php

namespace App\Repositories;

use App\Models\CategoryEvent;
use App\Repositories\Interfaces\CategoryEventRepositoryInterface;

class CategoryEventRepository implements CategoryEventRepositoryInterface
{
    public function getEventsIdByCategories(array $categoriesIds): array
    {
        return CategoryEvent::query()->select(['event_id'])->whereIn('category_id', $categoriesIds)->get()->toArray();
    }
}
