<?php

namespace App\Http\Requests\Communities;

use App\Constants\Request\CommunityRequestConstants;
use Illuminate\Foundation\Http\FormRequest;

class CommunityUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            CommunityRequestConstants::NAME => 'required|min:1|max:100|string',
        ];
    }
}
