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
        return $this->model->query()->where(CommentDBConstants::EVENT_ID, $eventId)->cursorPaginate(self::PER_PAGE)->toArray();
    }

    public function getEventId(string $id): string
    {
        return $this->model->query()->where(CommentDBConstants::ID, $id)->value(CommentDBConstants::EVENT_ID);
    }

    public function checkIsExistCommentByAuthor(string $id, string $userId): bool
    {
        return $this->model->query()->where(CommentDBConstants::ID, $id)->where(CommentDBConstants::AUTHOR_ID, $userId)->exists();
    }

    public function getAuthorId(string $id): string
    {
        return $this->model->query()->where(CommentDBConstants::ID, $id)->value(CommentDBConstants::AUTHOR_ID);
    }

    public function getCommentsByAuthorID(string $userId): array
    {
        return $this->model->query()->where(CommentDBConstants::AUTHOR_ID, $userId)->paginate(self::PER_PAGE)->toArray();
    }

    public function getCommentsByEvent(string $id): array
    {
        return $this->model->query()->with('event', 'author')->where('event_id', $id)->paginate()->toArray();
    }

    public function getComments(): array
    {
        return $this->model->query()->with('author', 'event')->paginate()->toArray();
    }
}
