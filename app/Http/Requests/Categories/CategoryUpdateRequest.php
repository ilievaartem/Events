<?php

namespace App\Http\Requests\Categories;

use App\Constants\DB\CategoryDBConstants;
use App\Constants\Request\CategoryRequestConstants;
use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            CategoryRequestConstants::NAME => 'required|string|max:35',
        ];
    }
}
