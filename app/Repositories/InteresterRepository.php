<?php

namespace App\Repositories;

use App\Constants\DB\InteresterDBConstants;
use App\Models\Interester;
use App\Repositories\Interfaces\InteresterRepositoryInterface;

class InteresterRepository extends BaseRepository implements InteresterRepositoryInterface
{
    public function checkIsInteresterExist(string $eventId, string $userId): bool
    {
        return Interester::query()->where(InteresterDBConstants::EVENT_ID, $eventId)->where(InteresterDBConstants::AUTHOR_ID, $userId)->exists();
    }
    public function getIdByEventIdAndUserId(string $eventId, string $userId): string
    {
        return Interester::query()
            ->where(InteresterDBConstants::EVENT_ID, $eventId)
            ->where(InteresterDBConstants::AUTHOR_ID, $userId)
            ->value(InteresterDBConstants::ID);
    }
}
