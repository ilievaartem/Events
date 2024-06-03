<?php

namespace App\Repositories;

use App\Models\CategoryEvent;
use App\Repositories\Interfaces\CategoryEventRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class CategoryEventRepository implements CategoryEventRepositoryInterface
{
    /**
     * @param array $categoriesIds
     * @return array
     */
    public function getEventsIdByCategories(array $categoriesIds): array
    {
        return CategoryEvent::query()->select(['event_id'])->whereIn('category_id', $categoriesIds)->get()->toArray();
    }

    /**
     * @param int $year
     * @param array $months
     * @return array
     */
    public function getCategoriesCountsByYearAndMonths(int $year, array $months): array
    {
        return CategoryEvent::query()
            ->whereYear('created_at', '=', $year)
            ->whereIn(DB::raw('EXTRACT(MONTH FROM created_at)'), $months)
            ->get()
            ->groupBy(function ($date) {
                return Carbon::parse($date->created_at)->format('m');
            })
            ->map(function ($categoryEvents) {
                return $categoryEvents->count();
            })
            ->toArray();
    }
}
