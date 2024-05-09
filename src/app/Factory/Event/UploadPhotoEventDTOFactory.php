<?php

namespace App\Factory\Event;

use App\Constants\DB\EventDBConstants;
use App\Constants\File\PathsConstants;
use App\Constants\Request\EventRequestConstants;
use App\DTO\Photos\CreatePhotoDTO;
use App\Services\EventService;
use App\Services\PhotoService;
use Illuminate\Http\Request;

class UploadPhotoEventDTOFactory
{
    public function __construct(
        private readonly PhotoService $photoService,
    ) {
    }

    public function make(Request $request, string $id): ?CreatePhotoDTO
    {
        if (!$request->hasFile(EventRequestConstants::MAIN_PHOTO)) {
            return null;
        }
        return new CreatePhotoDTO(
            currentPath: $request->file(EventRequestConstants::MAIN_PHOTO)->path(),
            extension: $request->file(EventRequestConstants::MAIN_PHOTO)->extension(),

            pathForDB: $this->photoService->makePhotoDirectoryNameForEvent(
                $id,
                $request->file(EventRequestConstants::MAIN_PHOTO)->extension(),
                PathsConstants::ENTITY_EVENT
            )
        );
    }
}
