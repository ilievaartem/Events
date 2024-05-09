<?php

namespace App\Factory\Question;

use App\Constants\Request\QuestionRequestConstants;
use App\DTO\Question\UpdateQuestionDTO;
use Illuminate\Http\Request;

class UpdateQuestionDTOFactory
{
    public function make(Request $request, string $questionId): UpdateQuestionDTO
    {
        return new UpdateQuestionDTO(
            questionId: $questionId,
            content: $request->input(QuestionRequestConstants::CONTENT),
        );
    }
}
