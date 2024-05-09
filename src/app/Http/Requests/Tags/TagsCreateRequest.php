<?php

namespace App\Http\Requests\Tags;

use App\Constants\Request\TagRequestConstants;
use Illuminate\Foundation\Http\FormRequest;

class TagsCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            TagRequestConstants::NAME => 'required|string|max:35',
        ];
    }
}
