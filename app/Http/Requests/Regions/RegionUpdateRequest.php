<?php

namespace App\Http\Requests\Regions;

use App\Constants\Request\RegionRequestConstants;
use Illuminate\Foundation\Http\FormRequest;

class RegionUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            RegionRequestConstants::NAME => 'required|min:1|max:100|string',
        ];
    }
}
