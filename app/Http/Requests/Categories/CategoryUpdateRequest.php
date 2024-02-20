<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\Request\CategoryRequestConstants;

class CategoryUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            CategoryRequestConstants::NAME => 'required|max:35',
        ];

    }
}
