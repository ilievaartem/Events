<?php

namespace App\Http\Requests\Users;

use Illuminate\Foundation\Http\FormRequest;
use App\Constants\Request\UserRequestConstants;

class UsersUpdateRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            UserRequestConstants::NAME => 'required|max:25',
            UserRequestConstants::EMAIL => 'required|email:rfc|max:60',
            UserRequestConstants::TELEPHONE => 'required|string|min:7|max:30',
            UserRequestConstants::PASSWORD => 'required|min:3|max:30'
        ];
    }
}
