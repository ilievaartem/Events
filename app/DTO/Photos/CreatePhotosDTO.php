<?php

namespace App\DTO\Photos;

use App\DTO\Contracts\DTOContract;

class CreatePhotosDTO implements DTOContract
{
    public function __construct(
        /**@var array<CreatePhotoDTO> */
        private readonly ?array $photos,
    ) {
    }
    /**
     *@var array<CreatePhotoDTO>
     */
    public function getPhotos(): ?array
    {
        return $this->photos;
    }
}
