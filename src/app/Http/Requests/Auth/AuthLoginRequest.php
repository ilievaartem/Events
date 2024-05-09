<?php

namespace App\Http\Requests\Auth;

use App\Constants\Request\AuthRequestConstants;
use Illuminate\Foundation\Http\FormRequest;

class AuthLoginRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            AuthRequestConstants::EMAIL => 'required|unique:users|email:rfc|max:60',
            AuthRequestConstants::PASSWORD => 'required|string|min:3|max:30',
        ];
    }
}
