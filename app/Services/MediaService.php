<?php

namespace App\Services;

use App\Constants\DB\MediaDBConstants;
use App\Constants\File\PathsConstants;
use App\DTO\Photos\CreatePhotosDTO;
use App\Exceptions\AuthException;
use App\Exceptions\ForbiddenException;
use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\MediaRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;

class MediaService
{
    public function __construct(
        private MediaRepositoryInterface $mediaRepository,
        private PhotoService $photoService,
        private CommentService $commentService,
        private EventService $eventService
    ) {

    }
    public function checkIsAuthor(string $id, string $authorId): void
    {
        $this->checkIsExist($id);
        if ($this->mediaRepository->checkIsExistMediaByAuthor($id, $authorId) == false) {
            throw new ForbiddenException("Current user did not create there media");
        }
    }
    public function index(): array
    {
        $index = $this->mediaRepository->index();
        if ($index != null) {
            return $index;
        }
        throw new NotFoundException("Medias are not found");
    }
    public function show(string $id): array
    {
        $this->checkIsExist($id);
        return $this->mediaRepository->show($id);
    }
    public function getCommentMedia(string $commentId): array
    {
        $this->commentService->checkIsExist($commentId);
        return $this->mediaRepository->getCommentMedia($commentId);
    }
    public function getEventMedia(string $eventId): array
    {
        $this->eventService->checkIsExist($eventId);
        return $this->mediaRepository->getEventMedia($eventId);
    }

    public function delete(string $id): bool
    {
        return $this->mediaRepository->checkIsExist($id)
            ? $this->deleteIfMediaExist($id)
            : true;
    }
    private function deleteIfMediaExist(string $id): bool
    {
        $oldPath = $this->mediaRepository->getPhotoPathById($id);
        $this->mediaRepository->delete($id);
        return $this->photoService->deleteOldPhoto($oldPath);
    }
    public function getPhotosDTO(?array $files, string $eventId): array
    {
        $this->eventService->checkIsExist($eventId);
        return $this->photoService->makePhotosDTO($files, $eventId, PathsConstants::ENTITY_MEDIA);
    }

    public function uploadPhotos(string $commentId, string $authorId, CreatePhotosDTO $photos): array
    {
        $this->commentService->checkIsExist($commentId);
        $this->mediaRepository->insert($this->formatForInsert($commentId, $authorId, $photos));
        $this->photoService->storagePhotos($this->photoService->getPhotosContentAndPath($photos));
        return $this->getCommentMedia($commentId);
    }
    private function formatForInsert(string $commentId, string $authorId, CreatePhotosDTO $photos): array
    {
        $photoPaths = $this->photoService->getPhotosPaths($photos);
        $eventId = $this->commentService->getEventId($commentId);
        foreach ($photoPaths as $path) {
            $media[] = [
                MediaDBConstants::ID => Str::orderedUuid(),
                MediaDBConstants::PATH => $path,
                MediaDBConstants::EVENT_ID => $eventId,
                MediaDBConstants::AUTHOR_ID => $authorId,
                MediaDBConstants::COMMENT_ID => $commentId,
            ];
        }
        return $media;
    }
    public function checkIsExist(string $id): void
    {
        if ($this->mediaRepository->checkIsExist($id) == false) {
            throw new NotFoundException("Media is not found");
        }
    }
}
