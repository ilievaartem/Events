<?php

namespace App\Factory\User;

use App\Constants\Request\UserRequestConstants;
use App\DTO\User\UpdateUserDTO;
use Illuminate\Http\Request;

class UpdateUserDTOFactory
{
    public function make(Request $request, string $userId): UpdateUserDTO
    {
        return new UpdateUserDTO(
            name: $request->input(UserRequestConstants::NAME),
            userId: $userId,
            telephone: $request->input(UserRequestConstants::TELEPHONE),
            email: $request->input(UserRequestConstants::EMAIL),
            password: $request->input(UserRequestConstants::PASSWORD),
        );
    }
}
