<?php

namespace App\DTO\Complaint;

use App\DTO\Contracts\DTOContract;

class CreateComplaintDTO implements DTOContract
{
    public function __construct(
        private readonly string $eventId,
        private readonly string $authorId,
        private readonly string $causeMessage,
        private readonly string $causeDescription,
    ) {
    }
    public function getEventId(): string
    {
        return $this->eventId;
    }
    public function getAuthorId(): string
    {
        return $this->authorId;
    }
    public function getCauseMessage(): string
    {
        return $this->causeMessage;
    }
    public function getCauseDescription(): string
    {
        return $this->causeDescription;
    }
}
