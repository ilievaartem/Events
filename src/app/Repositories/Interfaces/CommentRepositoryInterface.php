<?php

namespace App\Repositories\Interfaces;

interface CommentRepositoryInterface extends BaseRepositoryInterface
{
    public function getCommentsByEvent(string $id): array;
    public function getEventId(string $id): string;
    public function getAuthorId(string $id): string;
    public function checkIsExistCommentByAuthor(string $id, string $userId): bool;
    public function getCommentsByAuthorID(string $userId): array;
    public function getEventComments(string $eventId): array;
    public function getComments(): array;

}
