<?php

namespace App\Repositories;

use App\Constants\DB\MessageDBConstants;
use App\Models\Message;
use App\Repositories\Interfaces\MessageRepositoryInterface;

class MessageRepository extends BaseRepository implements MessageRepositoryInterface
{
    public function getMessageCreatedAt(string $id): string
    {
        return Message::query()->where(MessageDBConstants::ID, $id)->value(MessageDBConstants::CREATED_AT);
    }

}
