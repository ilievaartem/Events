<?php

namespace App\Http\Requests\Users;

use App\Constants\Request\UserRequestConstants;
use App\Services\PhotoService;
use Illuminate\Foundation\Http\FormRequest;

class UserUploadAvatarRequest extends FormRequest
{
    public function __construct(
        private readonly PhotoService $photoService,
    ) {
    }
    public function rules(): array
    {
        return [
            UserRequestConstants::AVATAR => 'file|mimes:' . $this->photoService->makePhotoExtensionsForValidation(),
        ];
    }
}
