<?php

namespace App\Repositories\Interfaces;

interface QuestionRepositoryInterface extends BaseRepositoryInterface
{
    public function getQuestionsByAuthorID(string $userId): array;
    public function checkIsQuestionHasCurrentAuthorId(string $eventId, string $authorId): bool;
    public function getEventQuestions(string $eventId): array;
    public function getQuestionCreatedAt(string $id): string;
    public function getQuestionsByEvent(string $id): array;
    public function getQuestions(): array;
}
