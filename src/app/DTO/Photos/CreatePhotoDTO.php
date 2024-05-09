<?php

namespace App\DTO\Photos;

use App\DTO\Contracts\DTOContract;

class CreatePhotoDTO implements DTOContract
{
    public function __construct(
        private readonly ?string $currentPath,
        private readonly ?string $extension,
        private readonly ?string $pathForDB,
    ) {
    }
    public function getCurrentPath(): ?string
    {
        return $this->currentPath;
    }
    public function getExtension(): ?string
    {
        return $this->extension;
    }
    public function getPathForDB(): ?string
    {
        return $this->pathForDB;
    }
}
