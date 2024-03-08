<?php

namespace App\Http\Requests\Events;

use App\Constants\Request\EventRequestConstants;
use App\Services\EventService;
use App\Services\PhotoService;
use Illuminate\Foundation\Http\FormRequest;

class EventUploadPhotosRequest extends FormRequest
{
    public function __construct(
        private readonly PhotoService $photoService,
    ) {
    }
    public function rules(): array
    {
        return [
            EventRequestConstants::MAIN_PHOTO => 'file|mimes:' . $this->photoService->makePhotoExtensionsForValidation(),
            EventRequestConstants::PHOTOS => 'array',
            EventRequestConstants::PHOTOS . '.*' => 'file|mimes:' . $this->photoService->makePhotoExtensionsForValidation(),

        ];
    }

    //
}
