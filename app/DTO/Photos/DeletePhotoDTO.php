<?php

namespace App\DTO\Photos;

class DeletePhotoDTO
{
    public function __construct(
        private readonly string $path,
    ) {
    }

    public function getPath(): string
    {
        return $this->path;
    }
}
