<?php

namespace App\Factory\Media;

use App\Constants\Request\MediaRequestConstants;
use App\DTO\Photos\CreatePhotosDTO;
use App\Services\MediaService;
use Illuminate\Http\Request;

class UploadCommentMediaDTOFactory
{
    public function __construct(
        private readonly MediaService $mediaService,
    ) {
    }
    public function make(Request $request, string $id): ?CreatePhotosDTO
    {
        if (!$request->hasFile(MediaRequestConstants::PHOTOS)) {
            return null;
        }
        return new CreatePhotosDTO($this->mediaService->getPhotosDTO($request->file(MediaRequestConstants::PHOTOS), $id));

    }
}
