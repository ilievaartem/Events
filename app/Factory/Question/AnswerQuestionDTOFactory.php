<?php

namespace App\Factory\Question;

use App\Constants\Request\QuestionRequestConstants;
use App\DTO\Question\AnswerQuestionDTO;
use Illuminate\Http\Request;

class AnswerQuestionDTOFactory
{
    public function make(Request $request, string $eventId, string $authorId): AnswerQuestionDTO
    {
        return new AnswerQuestionDTO(
            eventId: $eventId,
            authorId: $authorId,
            parentId: $request->input(QuestionRequestConstants::PARENT_ID),
            content: $request->input(QuestionRequestConstants::CONTENT),
        );
    }
}
