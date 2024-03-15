<?php

namespace App\Factory\Question;

use App\Constants\Request\QuestionRequestConstants;
use App\DTO\Question\ResponseToQuestionDTO;
use Illuminate\Http\Request;

class ResponseToQuestionDTOFactory
{
    public function make(Request $request, string $eventId, string $authorId): ResponseToQuestionDTO
    {
        return new ResponseToQuestionDTO(
            eventId: $eventId,
            authorId: $authorId,
            parentId: $request->input(QuestionRequestConstants::PARENT_ID),
            content: $request->input(QuestionRequestConstants::CONTENT),
        );
    }
}
