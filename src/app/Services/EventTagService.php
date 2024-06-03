<?php

namespace App\Services;

use App\Repositories\Interfaces\EventTagRepositoryInterface;

class EventTagService
{
    public function __construct(
        private readonly EventTagRepositoryInterface $eventTagRepository
    ) {
    }

    /**
     * @param array $tagsIds
     * @return array
     */
    public function getEventsIdByTags(array $tagsIds): array
    {
        return $this->eventTagRepository->getEventsIdByTags($tagsIds);
    }

    /**
     * @param int $year
     * @param array $months
     * @return array
     */
    public function getTagCountsByYearAndMonths(int $year, array $months): array
    {
        return $this->eventTagRepository->getTagCountsByYearAndMonths($year, $months);
    }
}
