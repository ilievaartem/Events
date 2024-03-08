<?php

namespace App\Factory\Event;

use App\Constants\DB\EventDBConstants;
use App\Constants\File\PathsConstants;
use App\Constants\Request\EventRequestConstants;
use App\DTO\Photos\CreatePhotosDTO;
use App\Services\EventService;
use App\Services\PhotoService;
use Illuminate\Http\Request;

class UploadPhotosEventDTOFactory
{
    public function __construct(
        private readonly PhotoService $photoService,
    ) {
    }
    public function make(Request $request, string $id): ?CreatePhotosDTO
    {
        if (!$request->hasFile(EventRequestConstants::PHOTOS)) {
            return null;
        }
        return new CreatePhotosDTO(
            $this->photoService->makePhotosDTO(
                $request->file(EventRequestConstants::PHOTOS),
                $id,
                PathsConstants::ENTITY_EVENT
            )
        );

    }

}
