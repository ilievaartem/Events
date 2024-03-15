<?php

namespace App\Http\Requests\Events;

use App\Constants\Request\EventRequestConstants;
use Illuminate\Foundation\Http\FormRequest;

class EventCreateRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */


    public function rules(): array
    {
        return [
            EventRequestConstants::TITLE => 'required|string|min:1|max:100',
            EventRequestConstants::LONGITUDE => 'required|min:5|max:40',
            EventRequestConstants::LATITUDE => 'required|min:5|max:40',
            EventRequestConstants::ADDITIONAL_AUTHOR => 'string|uuid',
            EventRequestConstants::DESCRIPTION => 'required|string|min:1|max:455',
            EventRequestConstants::SHORT_DESCRIPTION => 'required|string|min:1|max:100',
            EventRequestConstants::STREET_NAME => 'required|string|min:1|max:100',
            EventRequestConstants::BUILDING => 'string|min:1|max:100',
            EventRequestConstants::PLACE_NAME => 'string|min:1|max:100',
            EventRequestConstants::CORPUS => 'string|min:1|max:100',
            EventRequestConstants::APARTMENT => 'string|min:1|max:100',
            EventRequestConstants::PLACE_DESCRIPTION => 'required|string|min:1|max:255',
            EventRequestConstants::START_DATE => 'required|date_format:Y-m-d',
            EventRequestConstants::START_TIME => 'required|date_format:H:i:s',
            EventRequestConstants::FINISH_DATE => 'required|date_format:Y-m-d',
            EventRequestConstants::FINISH_TIME => 'required|date_format:H:i:s',
            EventRequestConstants::AGE => 'required|string|min:1|max:20',
            EventRequestConstants::CATEGORIES_IDS => 'required|array',
            EventRequestConstants::CATEGORIES_IDS . '.*' => 'integer|min:0',
            EventRequestConstants::TAGS_IDS => 'array',
            EventRequestConstants::TAGS_IDS . '.*' => 'integer|min:0',
            EventRequestConstants::APPLIERS => 'array',
            EventRequestConstants::APPLIERS . '.*' => 'integer|min:0',
            EventRequestConstants::INTERESTARS => 'array',
            EventRequestConstants::INTERESTARS . '.*' => 'integer|min:1',
            EventRequestConstants::IS_ONLINE => 'boolean',
            EventRequestConstants::IS_OFFLINE => 'boolean',
            EventRequestConstants::PARENT_ID => 'string|uuid',
            EventRequestConstants::CITY_ID => 'required|integer|min:0',
            EventRequestConstants::COUNTRY_ID => 'required|integer|min:0',

        ];
    }
}
