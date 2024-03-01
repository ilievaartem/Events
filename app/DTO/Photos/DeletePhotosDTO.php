<?php

namespace App\DTO\Photos;

use App\DTO\Contracts\DTOContract;

class DeletePhotosDTO implements DTOContract
{
    public function __construct(
        private readonly array $photos,
    ) {
    }

    public function getPhotos(): array
    {
        return $this->photos;
    }
}
