<?php

namespace App\DTO\Question;

use App\DTO\Contracts\DTOContract;

class UpdateQuestionDTO implements DTOContract
{
    public function __construct(
        private readonly string $questionId,
        private readonly string $content
    ) {
    }
    public function getQuestionId(): string
    {
        return $this->questionId;
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
