<?php

namespace App\Factory\User;

use App\Constants\File\PathsConstants;
use App\Constants\Request\UserRequestConstants;
use App\DTO\Photos\CreatePhotoDTO;
use App\Services\PhotoService;
use Illuminate\Http\Request;

class UploadUserAvatarDTOFactory
{
    public function __construct(
        private readonly PhotoService $photoService,
    ) {
    }

    public function make(Request $request, string $id): ?CreatePhotoDTO
    {
        if (!$request->hasFile(UserRequestConstants::AVATAR)) {
            return null;
        }
        return new CreatePhotoDTO(
            currentPath: $request->file(UserRequestConstants::AVATAR)->path(),
            extension: $request->file(UserRequestConstants::AVATAR)->extension(),

            pathForDB: $this->photoService->makePhotoDirectoryNameForEvent(
                $id,
                $request->file(UserRequestConstants::AVATAR)->extension(),
                PathsConstants::ENTITY_USER
            )
        );
    }
}
