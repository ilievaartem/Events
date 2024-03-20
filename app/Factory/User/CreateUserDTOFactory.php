<?php

namespace App\Factory\User;

use App\Constants\Request\UserRequestConstants;
use App\DTO\User\CreateUserDTO;
use Illuminate\Http\Request;

class CreateUserDTOFactory
{
    public function make(Request $request): CreateUserDTO
    {
        return new CreateUserDTO(
            name: $request->input(UserRequestConstants::NAME),
            role: $request->input(UserRequestConstants::ROLE),
            telephone: $request->input(UserRequestConstants::TELEPHONE),
            email: $request->input(UserRequestConstants::EMAIL),
            password: $request->input(UserRequestConstants::PASSWORD),
        );
    }
}
