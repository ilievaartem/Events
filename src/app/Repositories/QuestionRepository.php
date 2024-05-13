<?php

namespace App\Repositories;

use App\Constants\DB\QuestionDBConstants;
use App\Repositories\Interfaces\QuestionRepositoryInterface;

class QuestionRepository extends BaseRepository implements QuestionRepositoryInterface
{
    public function getQuestionCreatedAt(string $id): string
    {
        return $this->model->query()->where(QuestionDBConstants::ID, $id)->value(QuestionDBConstants::CREATED_AT);
    }

    public function getQuestionsByAuthorID(string $userId): array
    {
        return $this->model->query()->where(QuestionDBConstants::AUTHOR_ID, $userId)->cursorPaginate(self::PER_PAGE)->toArray();
    }

    public function getEventQuestions(string $eventId): array
    {
        return $this->model->query()->where(QuestionDBConstants::EVENT_ID, $eventId)->cursorPaginate(self::PER_PAGE)->toArray();
    }

    public function checkIsQuestionHasCurrentAuthorId(string $eventId, string $authorId): bool
    {
        return $this->model->where(QuestionDBConstants::ID, $eventId)
            ->where(QuestionDBConstants::AUTHOR_ID, $authorId)->exists();
    }

    public function getQuestionsByEvent(string $id): array
    {
        return $this->model->query()->with('event', 'author')->where('event_id', $id)->paginate()->toArray();
    }

    public function getQuestions(): array
    {
        return $this->model->query()->with('author', 'event')->paginate()->toArray();
    }
}
