<?php

namespace App\Repositories;

use App\Repositories\Interfaces\CommentRepositoryInterface;

use App\Models\Comment;
use App\Constants\DB\CommentConstants;
use App\Constants\DB\CommentDBConstants;
use App\Constants\DB\EventDBConstants;

class CommentRepository extends BaseRepository implements CommentRepositoryInterface
{
    public function getEventComments(string $eventId): array
    {
        return Comment::query()->where(CommentDBConstants::EVENT_ID, $eventId)->cursorPaginate(self::PER_PAGE)->toArray();
    }

    public function getEventId(string $id): string
    {
        return Comment::query()->where(CommentDBConstants::ID, $id)->value(CommentDBConstants::EVENT_ID);
    }
    public function checkIsExistCommentByAuthor(string $id, string $userId): bool
    {
        return Comment::query()->where(CommentDBConstants::ID, $id)->where(CommentDBConstants::AUTHOR_ID, $userId)->exists();
    }
    public function getAuthorId(string $id): string
    {
        return Comment::query()->where(CommentDBConstants::ID, $id)->value(CommentDBConstants::AUTHOR_ID);
    }
    public function getCommentsByAuthorID(string $userId): array
    {
        return Comment::where(CommentDBConstants::AUTHOR_ID, $userId)->paginate(self::PER_PAGE)->toArray();
    }
}
