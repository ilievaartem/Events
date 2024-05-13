<?php

namespace App\DTO\Comment;

use App\DTO\Contracts\DTOContract;

class CreateCommentDTO implements DTOContract{
    public function __construct(
        private readonly string $eventId,
        private readonly string $authorId,
        private readonly string $content,
    ) {}

    public function getEventId(): string {
        return $this->eventId;
    }
    public function getAuthorId(): string {
        return $this->authorId;
    }
    public function getContent(): string {
        return $this->content;
    }
}
