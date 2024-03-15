<?php

namespace App\Repositories;

use App\Constants\DB\QuestionDBConstants;
use App\Models\Question;
use App\Repositories\Interfaces\QuestionRepositoryInterface;

class QuestionRepository extends BaseRepository implements QuestionRepositoryInterface
{
    public function getQuestionCreatedAt(string $id): string
    {
        return Question::query()->where(QuestionDBConstants::ID, $id)->value(QuestionDBConstants::CREATED_AT);
    }
    public function getQuestionsByAuthorID(string $userId): array
    {
        return Question::where(QuestionDBConstants::AUTHOR_ID, $userId)->cursorPaginate(self::PER_PAGE)->toArray();
    }
    public function getEventQuestions(string $eventId): array
    {
        return Question::where(QuestionDBConstants::EVENT_ID, $eventId)->cursorPaginate(self::PER_PAGE)->toArray();
    }
    public function checkIsQuestionHasCurrentAuthorId(string $eventId, string $authorId): bool
    {
        return $this->model->where(QuestionDBConstants::ID, $eventId)
            ->where(QuestionDBConstants::AUTHOR_ID, $authorId)->exists();
    }
}
