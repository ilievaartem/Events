<?php

namespace App\Factory\Event;

use App\DTO\Photos\CreatePhotosDTO;
use App\Services\EventService;
use Illuminate\Http\Request;

class UploadPhotosEventDTOFactory
{
    public function __construct(
        private readonly EventService $eventService,
    ) {
    }
    public function make(Request $request, string $id): ?CreatePhotosDTO
    {
        if (!$request->hasFile('photos')) {
            return null;
        }
        return new CreatePhotosDTO($this->eventService->getMakePhotosDTO($request->file('photos'), $id));

    }

}
