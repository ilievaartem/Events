<?php

namespace App\Repositories\Interfaces;

interface MessageRepositoryInterface extends BaseRepositoryInterface
{
    public function getMessageCreatedAt(string $id): string;
    public function checkIsExistMessageByAuthor(string $id, string $authorId): bool;
    public function getMessages(): array;

}
