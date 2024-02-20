<?php

namespace App\Services;

use App\Repositories\Interfaces\PhotoRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PhotoService
{
    public function __construct(private PhotoRepositoryInterface $photoRepository)
    {
    }
    public function makeMainPhotoDirectoryNameForEvent(string $id, string $photoExtension): string
    {
        return '/event/' . $id . '/photos/' . Str::random(8) . '.' . $photoExtension;
        // return '/event/' . $id . '/photos/' . Str::random(8) . '.' . $photoExtension;
    }
    public function makeMainPhotoDirectoryNameForUser(string $id, string $photoExtension): string
    {
        return '/user/' . $id . '/avatar/' . Str::random(8) . '.' . $photoExtension;
    }
    public function makeMainPhotoDirectoryNameForMedia(string $id, string $photoExtension): string
    {
        return '/media/comments/' . $id . '/photo/' . Str::random(8) . '.' . $photoExtension;
    }

    public function makeMainPhotosDirectoryNameForEvent(string $id, ?array $photos): array
    {
        $photos_directory = [];
        foreach ($photos as $photo) {
            $photos_directory[] = $photo['path'];
        }
        return $photos_directory;
    }
    public function storagePhoto(string $directory, string $photo): void
    {
        $this->photoRepository->savePhoto($directory, $photo);
    }
    public function storagePhotos(?array $photos): void
    {
        foreach ($photos as $photo) {
            $this->storagePhoto($photo['path'], $photo['photo']);
        }
    }
    public function getMainPhotoPath(string $id, string $mainPhotoExtension): string
    {
        return $this->makeMainPhotoDirectoryNameForEvent($id, $mainPhotoExtension);

    }
    public function getPhotosPaths(string $id, ?array $photos): array
    {
        return $this->makeMainPhotosDirectoryNameForEvent($id, $photos);

    }
    public function loadPhotos(?string $mainPhoto, string $mainPhotoPath, ?array $photos): void
    {

        $this->storagePhoto($mainPhotoPath, $mainPhoto);
        $this->storagePhotos($photos);

    }
    public function loadPhoto(string $photo, string $photoPath): void
    {
        $this->storagePhoto($photoPath, $photo);
    }
    public function deleteOldPhotos(array $oldPhotos): void
    {
        foreach ($oldPhotos as $photo) {
            $this->photoRepository->deletePhotos($photo);
        }
    }
    public function deleteOldPhoto(string $oldPhoto): void
    {
        $this->photoRepository->deletePhotos($oldPhoto);

    }
}
