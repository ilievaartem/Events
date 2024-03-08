<?php

namespace App\Repositories\Interfaces;

interface QuestionRepositoryInterface extends BaseRepositoryInterface
{
    public function getQuestionsByAuthorID(string $userId): array;
    public function checkIsQuestionHasCurrentAuthorId(string $eventId, string $authorId): bool;

}
