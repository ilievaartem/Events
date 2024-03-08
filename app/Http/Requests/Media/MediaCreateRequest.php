<?php

namespace App\Http\Requests\Media;

use App\Constants\Request\MediaRequestConstants;
use App\Services\PhotoService;
use Illuminate\Foundation\Http\FormRequest;

class MediaCreateRequest extends FormRequest
{
    public function __construct(
        private readonly PhotoService $photoService,
    ) {
    }
    public function rules(): array
    {
        return [
            MediaRequestConstants::PHOTOS => 'array',
            MediaRequestConstants::PHOTOS . '.*' => 'file|mimes:' . $this->photoService->makePhotoExtensionsForValidation(),
        ];
    }
}
