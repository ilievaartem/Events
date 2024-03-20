<?php

namespace App\Factory\Auth;

use App\Constants\Request\AuthRequestConstants;
use App\DTO\Auth\AuthRegisterDTO;
use Illuminate\Http\Request;

class AuthRegisterDTOFactory
{
    public function make(Request $request): AuthRegisterDTO
    {
        return new AuthRegisterDTO(
            name: $request->input(AuthRequestConstants::NAME),
            email: $request->input(AuthRequestConstants::EMAIL),
            telephone: $request->input(AuthRequestConstants::TELEPHONE),
            password: $request->input(AuthRequestConstants::PASSWORD),
        );
    }
}
