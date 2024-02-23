<?php

namespace App\Repositories\Interfaces;

use App\DTO\Event\FilterEventDTO;

interface EventFilterRepositoryInterface
{
    public function filterEvents(FilterEventDTO $filterEventDTO): ?array;

}
