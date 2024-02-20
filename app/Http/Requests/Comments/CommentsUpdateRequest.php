<?php

namespace App\Http\Requests\Comments;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\Request\CommentRequestConstants;

class CommentsUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            CommentRequestConstants::CONTENT => 'required|string|max:255'
        ];
    }
}
