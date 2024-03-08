<?php

namespace App\Repositories;

use App\Constants\DB\ApplierDBConstants;
use App\Models\Applier;
use App\Repositories\Interfaces\ApplierRepositoryInterface;

class ApplierRepository extends BaseRepository implements ApplierRepositoryInterface
{
    public function checkIsApplierExist(string $eventId, string $userId): bool
    {
        return Applier::query()->where(ApplierDBConstants::EVENT_ID, $eventId)->where(ApplierDBConstants::AUTHOR_ID, $userId)->exists();
    }
    public function getIdByEventIdAndUserId(string $eventId, string $userId): string
    {
        return Applier::query()
            ->where(ApplierDBConstants::EVENT_ID, $eventId)
            ->where(ApplierDBConstants::AUTHOR_ID, $userId)
            ->value(ApplierDBConstants::ID);
    }
}
