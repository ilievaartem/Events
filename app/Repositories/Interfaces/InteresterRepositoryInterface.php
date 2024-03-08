<?php

namespace App\Repositories\Interfaces;

interface InteresterRepositoryInterface extends BaseRepositoryInterface
{
    public function checkIsInteresterExist(string $eventId, string $userId): bool;
    public function getIdByEventIdAndUserId(string $eventId, string $userId): string;
}
