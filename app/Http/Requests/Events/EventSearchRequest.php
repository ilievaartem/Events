<?php

namespace App\Http\Requests\Events;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\Request\EventRequestConstants;
use App\Constants\Request\UserRequestConstants;

class EventSearchRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            EventRequestConstants::TITLE => 'nullable|max:55',
            EventRequestConstants::DESCRIPTION => 'nullable|string',
        ];
    }
}
