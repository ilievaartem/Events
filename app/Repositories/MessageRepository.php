<?php

namespace App\Repositories;

use App\Constants\DB\MessageDBConstants;
use App\Models\Message;
use App\Repositories\Interfaces\MessageRepositoryInterface;

class MessageRepository extends BaseRepository implements MessageRepositoryInterface
{

    public function checkIsExistMessageByAuthor(string $id, string $authorId): bool
    {
        return Message::query()->where(MessageDBConstants::ID, $id)->where(MessageDBConstants::AUTHOR_ID, $authorId)->exists();
    }

    public function getMessageCreatedAt(string $id): string
    {
        return Message::query()->where(MessageDBConstants::ID, $id)->value(MessageDBConstants::CREATED_AT);
    }

}
