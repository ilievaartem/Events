<?php

namespace App\Http\Requests\Auth;

use App\Constants\Request\AuthRequestConstants;
use Illuminate\Foundation\Http\FormRequest;

class AuthRegisterRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            AuthRequestConstants::NAME => 'required|string|max:35',
            AuthRequestConstants::EMAIL => 'required|unique:users|email:rfc|max:60',
            AuthRequestConstants::TELEPHONE => 'required|string|max:15',
            AuthRequestConstants::PASSWORD => 'required|string|min:3|max:30',
        ];
    }
}
