<?php

namespace App\Http\Requests\Events;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\Request\EventRequestConstants;

class EventFilterRequest extends FormRequest
{
    public function rules(): array
    {


        return [


            EventRequestConstants::PHRASE => 'string|min:1|max:255',
            EventRequestConstants::LONGITUDE => 'numeric',
            EventRequestConstants::LATITUDE => 'numeric',
            EventRequestConstants::SEARCH_BY => 'array',
            EventRequestConstants::SEARCH_BY . '*' => 'string|in:' .
                EventRequestConstants::TITLE,
            EventRequestConstants::DESCRIPTION,
            EventRequestConstants::STREET_NAME,
            EventRequestConstants::PLACE_NAME,
            EventRequestConstants::START_DATE_MIN => 'date|date_format:Y-m-d',
            EventRequestConstants::START_DATE_MAX => 'date|date_format:Y-m-d',
            EventRequestConstants::FINISH_DATE_MIN => 'date|date_format:Y-m-d',
            EventRequestConstants::FINISH_DATE_MAX => 'date|date_format:Y-m-d',
            EventRequestConstants::START_TIME_MIN => 'date_format:H:i:s',
            EventRequestConstants::START_TIME_MAX => 'date_format:H:i:s',
            EventRequestConstants::FINISH_TIME_MIN => 'date_format:H:i:s',
            EventRequestConstants::FINISH_TIME_MAX => 'date_format:H:i:s',
            EventRequestConstants::AGE => 'string|min:1|max:20',
            EventRequestConstants::RATING_MIN => 'numeric|min:1|max:5',
            EventRequestConstants::RATING_MAX => 'numeric|min:1|max:5',
            EventRequestConstants::AUTHOR_ID => 'string|uuid',
            EventRequestConstants::PARENT_ID => 'string|uuid',
            EventRequestConstants::COUNTRY_ID => 'integer|min:0',
            EventRequestConstants::REGION_ID => 'integer|min:0',
            EventRequestConstants::COMMUNITY_ID => 'integer|min:0',
            EventRequestConstants::PLACE_ID => 'integer|min:0',
        ];
    }
}
