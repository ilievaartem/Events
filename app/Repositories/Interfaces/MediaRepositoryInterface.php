<?php

namespace App\Repositories\Interfaces;

interface MediaRepositoryInterface extends BaseRepositoryInterface
{

    public function getPhotoPathById(string $id): string;
    public function getMediaByCommentId(string $commentId): array;
    public function checkIsExistByCommentId(string $commentId): bool;


}
