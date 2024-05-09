<?php

namespace App\Repositories;

use App\Constants\DB\TagDBConstants;
use App\Models\Tag;
use App\Repositories\Interfaces\TagRepositoryInterface;

class TagRepository extends BaseRepository implements TagRepositoryInterface
{
    public function checkIsExistByName(string $name): bool
    {
        return Tag::query()->where(TagDBConstants::NAME, $name)->exists();
    }
}
