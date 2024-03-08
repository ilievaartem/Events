<?php

namespace App\Http\Requests\Media;

use App\Constants\Request\MediaRequestConstants;
use Illuminate\Foundation\Http\FormRequest;

class MediaDeleteRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            MediaRequestConstants::PHOTOS => 'required|array',
            MediaRequestConstants::PHOTOS . '.*' => 'string|required|custom_media_path',

        ];
    }
}
