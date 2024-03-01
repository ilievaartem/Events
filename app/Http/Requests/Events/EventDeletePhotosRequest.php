<?php

namespace App\Http\Requests\Events;

use App\Constants\Request\EventRequestConstants;
use Illuminate\Foundation\Http\FormRequest;

class EventDeletePhotosRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            EventRequestConstants::PHOTOS => 'required|array',
            EventRequestConstants::PHOTOS . '.*' => 'string|required|custom_event_path',

        ];
    }


}
