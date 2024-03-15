<?php

namespace App\Repositories\Interfaces;

interface MediaRepositoryInterface extends BaseRepositoryInterface
{

    public function getPhotoPathById(string $id): string;
    public function checkIsExistByCommentId(string $commentId): bool;
    public function checkIsExistMediaByAuthor(string $id, string $authorId): bool;
    public function getCommentMedia(string $commentId): array;

    public function getEventMedia(string $eventId): array;

}
