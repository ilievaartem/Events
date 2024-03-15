<?php

namespace App\Services;

use App\Repositories\Interfaces\EventTagRepositoryInterface;

class EventTagService
{
    public function __construct(
        private EventTagRepositoryInterface $eventTagRepository
    ) {
    }
    public function getEventsIdByTags(array $tagsIds): array
    {
        return $this->eventTagRepository->getEventsIdByTags($tagsIds);
    }
}
