<?php

namespace App\Repositories;

use App\Models\EventTag;
use App\Repositories\Interfaces\EventTagRepositoryInterface;

class EventTagRepository implements EventTagRepositoryInterface
{
    public function getEventsIdByTags(array $tagsIds): array
    {
        return EventTag::query()->select(['event_id'])->whereIn('tag_id', $tagsIds)->get()->toArray();
    }
}
