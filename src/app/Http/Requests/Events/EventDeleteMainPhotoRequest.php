<?php

namespace App\Http\Requests\Events;

use App\Constants\Request\EventRequestConstants;
use Illuminate\Foundation\Http\FormRequest;

class EventDeleteMainPhotoRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            EventRequestConstants::MAIN_PHOTO => 'string|required|custom_event_path'
        ];
    }


}
