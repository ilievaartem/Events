<?php

namespace App\Repositories;

use App\Repositories\Interfaces\PhotoRepositoryInterface;

class PhotoRepository extends FileRepository implements PhotoRepositoryInterface
{
    public function savePhoto(string $directory, string $photo): void
    {
        $this->save($directory, $photo);
    }
    public function deletePhotos(string $directory): void
    {
        $this->delete($directory);
    }
}
