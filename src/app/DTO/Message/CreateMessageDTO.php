<?php

namespace App\DTO\Message;

use App\DTO\Contracts\DTOContract;

class CreateMessageDTO implements DTOContract
{
    public function __construct(
        private readonly string $eventId,
        private readonly string $responderId,
        private readonly string $receiverId,
        private readonly string $text
    ) {
    }
    public function getEventId(): string
    {
        return $this->eventId;
    }
    public function getResponderId(): string
    {
        return $this->responderId;
    }
    public function getReceiverId(): string
    {
        return $this->receiverId;
    }
    public function getText(): string
    {
        return $this->text;
    }

}
