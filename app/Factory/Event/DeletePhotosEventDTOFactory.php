<?php

namespace App\Factory\Event;

use App\Constants\Request\EventRequestConstants;
use App\DTO\Photos\DeletePhotosDTO;
use Illuminate\Http\Request;

class DeletePhotosEventDTOFactory
{
    public function make(Request $request, string $id): DeletePhotosDTO
    {
        return new DeletePhotosDTO(photos: $request->input(EventRequestConstants::PHOTOS));
    }
}
