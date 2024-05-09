<?php

namespace App\Factory\Event;

use App\Constants\Request\EventRequestConstants;
use App\DTO\Photos\DeletePhotoDTO;
use Illuminate\Http\Request;

class DeleteMainPhotoEventDTOFactory
{
    public function make(Request $request, string $id): ?DeletePhotoDTO
    {

        return new DeletePhotoDTO(
            path: $request->input(EventRequestConstants::MAIN_PHOTO)
        );
    }
}
