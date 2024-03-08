<?php

namespace App\Http\Requests\Questions;

use App\Constants\Request\QuestionRequestConstants;
use Illuminate\Foundation\Http\FormRequest;

class QuestionsUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            QuestionRequestConstants::CONTENT => 'required|min:1|max:250|string',
        ];
    }

}
