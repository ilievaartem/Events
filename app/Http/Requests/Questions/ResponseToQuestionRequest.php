<?php

namespace App\Http\Requests\Questions;

use App\Constants\Request\QuestionRequestConstants;
use Illuminate\Foundation\Http\FormRequest;

class ResponseToQuestionRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            QuestionRequestConstants::PARENT_ID => 'required|uuid',
            QuestionRequestConstants::CONTENT => 'required|min:1|max:250|string',
        ];
    }
}
