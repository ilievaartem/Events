<?php

namespace App\Http\Requests\Events;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\Request\EventRequestConstants;

class EventFilterRequest extends FormRequest
{
    public function rules(): array
    {


        return [


            EventRequestConstants::PHRASE => 'string|max:255',
            EventRequestConstants::RATING_MIN => 'numeric|min:1|max:5',
            EventRequestConstants::RATING_MAX => 'numeric|min:1|max:5',
            EventRequestConstants::CATEGORIES_IDS => 'array',
            EventRequestConstants::TAGS_IDS => 'array',
        ];
    }
}
