<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\Request\EventRequestConstants;

class EventCreateRequest extends FormRequest
{

    /**
     * Determine if the user is authorized to make this request.
     */
    //public function authorize(): bool
    //{
    //    return false;
    //  }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    // 'categories_ids',
    // 'tags_ids',
    // 'price',
    // 'rating',
    // 'description'
    public function rules(): array
    {
        return [
            EventRequestConstants::TITLE => 'required|unique:events|max:255',
            EventRequestConstants::CATEGORIES_IDS => 'required|array',
            EventRequestConstants::TAGS_IDS => 'required|array',
            EventRequestConstants::RATING => 'required|numeric|min:1|max:5',
            EventRequestConstants::DESCRIPTION => 'required',
        ];
    }
}
