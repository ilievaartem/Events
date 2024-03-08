<?php

namespace App\Repositories;

use App\Constants\DB\QuestionDBConstants;
use App\Models\Question;
use App\Repositories\Interfaces\QuestionRepositoryInterface;

class QuestionRepository extends BaseRepository implements QuestionRepositoryInterface
{
    public function getQuestionsByAuthorID(string $userId): array
    {
        return Question::where(QuestionDBConstants::AUTHOR_ID, $userId)->paginate(self::PER_PAGE)->toArray();
    }
    public function checkIsQuestionHasCurrentAuthorId(string $eventId, string $authorId): bool
    {
        return $this->model->where(QuestionDBConstants::ID, $eventId)
            ->where(QuestionDBConstants::AUTHOR_ID, $authorId)->exists();
    }
}
