<?php

namespace App\Repositories;

use App\Constants\DB\ArchiveTables\EventArchiveDBConstants;
use App\Models\EventArchive;
use App\Repositories\Interfaces\EventArchiveRepositoryInterface;

class EventArchiveRepository extends BaseRepository implements EventArchiveRepositoryInterface
{
    public function showUserEventArchives($userId): array
    {
        return EventArchive::query()->where(EventArchiveDBConstants::AUTHOR_ID, $userId)->cursorPaginate(self::PER_PAGE)->toArray();
    }
}
