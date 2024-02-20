<?php

namespace App\Http\Requests\Events;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\Request\EventRequestConstants;

class EventUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            EventRequestConstants::TITLE => 'required|unique:events|max:255',
            EventRequestConstants::CATEGORIES_IDS => 'required|array',
            EventRequestConstants::TAGS_IDS => 'required|array',
            EventRequestConstants::DESCRIPTION => 'required',
        ];
    }
}
