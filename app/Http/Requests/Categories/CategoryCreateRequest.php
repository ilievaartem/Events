<?php

namespace App\Http\Requests\Category;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\Request\CategoryRequestConstants;

class CategoryCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            CategoryRequestConstants::NAME => 'required|unique:categories|max:35',
            CategoryRequestConstants::PARENT_ID => '|numeric',
        ];
    }

}
