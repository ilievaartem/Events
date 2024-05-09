<?php

namespace App\Services;

use App\Constants\File\PathsConstants;
use App\Constants\Request\PhotoRequestConstants;
use App\DTO\Photos\CreatePhotoDTO;
use App\DTO\Photos\CreatePhotosDTO;
use App\Repositories\Interfaces\PhotoRepositoryInterface;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PhotoService
{
    public function __construct(private PhotoRepositoryInterface $photoRepository)
    {
    }
    public function makePhotoDirectoryNameForEvent(string $id, string $photoExtension, string $entityName): string
    {
        return $entityName . $id . PathsConstants::PHOTOS . Str::random(8) . '.' . $photoExtension;
    }
    public function makeMainPhotoDirectoryNameForUser(string $id, string $photoExtension): string
    {
        return '/user/' . $id . '/avatar/' . Str::random(8) . '.' . $photoExtension;
    }
    public function makeMainPhotoDirectoryNameForMedia(string $id, string $photoExtension): string
    {
        return '/media/comments/' . $id . '/photo/' . Str::random(8) . '.' . $photoExtension;
    }
    public function getPhotoContent(string $photoPath): string
    {
        return file_get_contents($photoPath);
    }

    public function makePhotosDTO(?array $files, string $id, string $entityName): ?array
    {
        if ($files == null) {
            return null;
        }
        foreach ($files as $file) {

            $formatPhotos[] = new CreatePhotoDTO(
                $file->path(),
                $file->extension(),
                $this->makePhotoDirectoryNameForEvent($id, $file->extension(), $entityName)
            );

        }
        return $formatPhotos;
    }
    public function makePhotoExtensionsForValidation(): string
    {
        return PhotoRequestConstants::EXTENSION_JPG . ',' . PhotoRequestConstants::EXTENSION_BMP . ',' . PhotoRequestConstants::EXTENSION_PNG;
    }
    public function unionPhotos(?array $photos): ?array
    {

        if (!empty ($photos['main_photo']) && !empty ($photos['photos'])) {
            return [

                ...$photos['photos'],
                $photos['main_photo'],

            ];
        }
        if (!empty ($photos['main_photo'])) {
            return [
                $photos['main_photo']
            ];
        }
        if (!empty ($photos['photos'])) {
            return $photos['photos'];
        }
        return [];

    }
    public function getPhotosContentAndPath(?CreatePhotosDTO $photos): array
    {

        $photosForStorage = [];
        foreach ($photos->getPhotos() as $photo) {

            $photosForStorage[] = [
                'photo' => $this->getPhotoContent($photo->getCurrentPath()),
                'path' => $photo->getPathForDB(),
            ];
        }
        return $photosForStorage;
    }
    public function deleteOldPhotoByPath(?string $oldPhotoPath): void
    {
        if ($oldPhotoPath == null) {
            return;
        }
        $this->deleteOldPhoto($oldPhotoPath);
    }
    public function storagePhoto(string $directory, string $photo): void
    {
        $this->photoRepository->savePhoto($directory, $photo);
    }
    public function storagePhotos(array $photos): void
    {
        foreach ($photos as $photo) {
            $this->storagePhoto($photo['path'], $photo['photo']);
        }
    }

    public function getPhotosPaths(?CreatePhotosDTO $photos): array
    {
        $photos_directory = [];
        foreach ($photos->getPhotos() as $photo) {
            $photos_directory[] = $photo->getPathForDB();
        }
        return $photos_directory;

    }

    public function loadPhoto(string $photo, string $photoPath): void
    {
        $this->storagePhoto($photoPath, $photo);
    }
    public function deleteOldPhotos(array $oldPhotos): bool
    {
        foreach ($oldPhotos as $photo) {
            $this->photoRepository->deletePhotos($photo);
        }
        return true;
    }
    public function deleteOldPhoto(string $oldPhoto): bool
    {
        $this->photoRepository->deletePhotos($oldPhoto);
        return true;
    }
}
