<?php

namespace App\Repositories;

use App\Constants\DB\ApplierDBConstants;
use App\Models\Applier;
use App\Repositories\Interfaces\ApplierRepositoryInterface;

class ApplierRepository extends BaseRepository implements ApplierRepositoryInterface
{
    public function EventAppliers(string $eventId): array
    {
        return Applier::query()->where(ApplierDBConstants::EVENT_ID, $eventId)->cursorPaginate(self::PER_PAGE)->toArray();
    }
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
    public function applierCount(string $eventId): int
    {
        return $this->model->query()->where(ApplierDBConstants::EVENT_ID, $eventId)->count();
    }
}
