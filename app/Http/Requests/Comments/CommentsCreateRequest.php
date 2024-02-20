<?php

namespace App\Http\Requests\Comments;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\Request\CommentRequestConstants;

class CommentsCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            CommentRequestConstants::EVENT_ID => 'required|numeric',
            CommentRequestConstants::CONTENT => 'required|string|max:255'
        ];
    }
}
