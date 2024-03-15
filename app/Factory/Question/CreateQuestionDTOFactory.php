<?php

namespace App\Factory\Question;

use App\Constants\Request\QuestionRequestConstants;
use App\DTO\Question\CreateQuestionDTO;
use App\Http\Requests\Questions\CreateQuestionRequest;
use Illuminate\Http\Request;

class CreateQuestionDTOFactory
{
    public function make(Request $request, string $eventId, string $authorId): CreateQuestionDTO
    {
        return new CreateQuestionDTO(
            eventId: $eventId,
            authorId: $authorId,
            content: $request->input(QuestionRequestConstants::CONTENT),
        );
    }
}
