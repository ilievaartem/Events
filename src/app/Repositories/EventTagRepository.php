<?php

namespace App\Repositories;

use App\Models\EventTag;
use App\Repositories\Interfaces\EventTagRepositoryInterface;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EventTagRepository implements EventTagRepositoryInterface
{
    /**
     * @param array $tagsIds
     * @return array
     */
    public function getEventsIdByTags(array $tagsIds): array
    {
        return EventTag::query()->select(['event_id'])->whereIn('tag_id', $tagsIds)->get()->toArray();
    }

    /**
     * @param int $year
     * @param array $months
     * @return array
     */
    public function getTagCountsByYearAndMonths(int $year, array $months): array
    {
        return EventTag::query()
            ->whereYear('created_at', '=', $year)
            ->whereIn(DB::raw('EXTRACT(MONTH FROM created_at)'), $months)
            ->get()
            ->groupBy(function ($dateEventsTags) {
                return Carbon::parse($dateEventsTags->created_at)->format('m');
            })
            ->map(function ($eventsTags) {
                return $eventsTags->count();
            })
            ->toArray();
    }
}
