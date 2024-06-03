<?php

namespace App\Repositories\Interfaces;

interface EventTagRepositoryInterface
{
    public function getEventsIdByTags(array $tagsIds): array;

    public function getTagCountsByYearAndMonths(int $year, array $months): array;

}
