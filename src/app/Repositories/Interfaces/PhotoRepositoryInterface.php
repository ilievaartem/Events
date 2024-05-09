<?php

namespace App\Repositories\Interfaces;

interface PhotoRepositoryInterface
{
    public function savePhoto(string $directory, string $photo): void;
    public function deletePhotos(string $directory): void;
}
