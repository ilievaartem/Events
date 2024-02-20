<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CommentRepositoryInterface;

use App\Models\Comment;
use App\Constants\DB\CommentConstants;
use App\Constants\DB\CommentDBConstants;
use App\Constants\DB\EventDBConstants;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    public function getEventId(string $id): string
    {
        return Comment::query()->where(CommentDBConstants::ID, $id)->value(CommentDBConstants::EVENT_ID);
    }
    public function getAuthorId(string $id): string
    {
        return Comment::query()->where(CommentDBConstants::ID, $id)->value(CommentDBConstants::AUTHOR_ID);
    }
}
