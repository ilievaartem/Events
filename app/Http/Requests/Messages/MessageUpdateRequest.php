<?php

namespace App\Http\Requests\Messages;

use App\Constants\Request\MessageRequestConstants;
use Illuminate\Foundation\Http\FormRequest;

class MessageUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            MessageRequestConstants::TEXT => 'required|min:1|max:250|string',
        ];
    }

}
