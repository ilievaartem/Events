<?php

namespace App\Repositories;

use App\Constants\DB\CategoryDBConstants;
use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository extends BaseRepository implements CategoryRepositoryInterface
{
    public function getCategoryChild(int $parentId): array
    {
        return Category::query()->where(CategoryDBConstants::PARENT_ID, $parentId)->cursorPaginate(self::PER_PAGE)->toArray();
    }
    public function checkIsExistByName(string $name): bool
    {
        return Category::query()->where(CategoryDBConstants::NAME, $name)->exists();
    }
}

