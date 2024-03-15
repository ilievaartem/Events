<?php

namespace App\Repositories\Interfaces;

interface EventTagRepositoryInterface
{
    public function getEventsIdByTags(array $tagsIds): array;

}
