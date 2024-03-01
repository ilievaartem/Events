<?php

namespace App\Http\Requests\Events;

use App\Constants\Request\EventRequestConstants;
use App\Services\EventService;
use Illuminate\Foundation\Http\FormRequest;

class EventUploadPhotosRequest extends FormRequest
{
    public function __construct(
        private readonly EventService $eventService,
    ) {
    }
    public function rules(): array
    {
        return [
            EventRequestConstants::MAIN_PHOTO => 'file|mimes:' . $this->eventService->getPhotoExtensionsForValidation(),
            EventRequestConstants::PHOTOS => 'array',
            EventRequestConstants::PHOTOS . '.*' => 'file|mimes:' . $this->eventService->getPhotoExtensionsForValidation(),

        ];
    }

    //
}
