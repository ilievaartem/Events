<?php

namespace App\Factory\Event;

use App\DTO\Photos\CreatePhotoDTO;
use App\Services\EventService;
use Illuminate\Http\Request;

class UploadPhotoEventDTOFactory
{
    public function __construct(
        private readonly EventService $eventService,
    ) {
    }

    public function make(Request $request, string $id): ?CreatePhotoDTO
    {
        if (!$request->hasFile('main_photo')) {
            return null;
        }
        return new CreatePhotoDTO(
            currentPath: $request->file('main_photo')->path(),
            extension: $request->file('main_photo')->extension(),
            pathForDB: $this->eventService->getPhotoPathForDB($id, $request->file('main_photo')->extension())
        );
    }
}
