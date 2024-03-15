<?php

namespace App\DTO\Question;

use App\DTO\Contracts\DTOContract;

class ResponseToQuestionDTO implements DTOContract
{
    public function __construct(
        private readonly string $eventId,
        private readonly string $authorId,
        private readonly string $parentId,
        private readonly string $content
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
    public function getContent(): string
    {
        return $this->content;
    }
    public function getParentId(): string
    {
        return $this->parentId;
    }
}
