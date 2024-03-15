<?php

namespace App\Http\Requests\Countries;

use App\Constants\Request\CountryRequestConstants;
use Illuminate\Foundation\Http\FormRequest;

class CountryCreateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            CountryRequestConstants::NAME => 'required|min:1|max:100|string',
        ];
    }
}
