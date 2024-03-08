<?php

namespace App\Services;

use App\Constants\DB\MediaDBConstants;
use App\Constants\File\PathsConstants;
use App\DTO\Photos\CreatePhotosDTO;
use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\MediaRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Illuminate\Support\Str;

class MediaService
{
    public function __construct(private MediaRepositoryInterface $mediaRepository, private PhotoService $photoService, private CommentService $commentService)
    {

    }
    public function index(): array
    {
        $index = $this->mediaRepository->index();
        if ($index != null) {
            return $index;
        }
        throw new NotFoundException("Medias are not found");
    }
    public function show(string $id): ?array
    {
        $this->checkIsExist($id);
        return $this->mediaRepository->show($id);
    }

    public function delete(string $id): bool
    {
        $this->checkIsExist($id);
        $oldPath = $this->mediaRepository->getPhotoPathById($id);
        $this->mediaRepository->delete($id);
        return $this->photoService->deleteOldPhoto($oldPath);

    }
    public function getPhotosDTO(?array $files, string $id): array
    {
        return $this->photoService->makePhotosDTO($files, $id, PathsConstants::ENTITY_MEDIA);
    }
    public function getMediaByCommentId(string $commentId): ?array
    {
        $checkIsMediaExist = $this->mediaRepository->checkIsExistByCommentId($commentId);

        if ($checkIsMediaExist == false) {
            return null;
        }
        return $this->mediaRepository->getMediaByCommentId($commentId);
    }
    public function uploadPhotos(string $commentId, CreatePhotosDTO $photos): array
    {
        $this->formatForInsert($commentId, $photos);
        $this->photoService->storagePhotos($this->photoService->getPhotosContentAndPath($photos));
        return $this->getMediaByCommentId($commentId);
    }
    private function formatForInsert(string $commentId, CreatePhotosDTO $photos): void
    {
        $photoPaths = $this->photoService->getPhotosPaths($photos);
        $eventId = $this->commentService->getEventId($commentId);
        $authorId = $this->commentService->getAuthorId($commentId);
        foreach ($photoPaths as $path) {
            $media[] = [
                MediaDBConstants::ID => Str::orderedUuid(),
                MediaDBConstants::PATH => $path,
                MediaDBConstants::EVENT_ID => $eventId,
                MediaDBConstants::AUTHOR_ID => $authorId,
                MediaDBConstants::COMMENT_ID => $commentId,
            ];
        }
        $this->mediaRepository->insert($media);
    }
    public function checkIsExist(string $id): void
    {
        if ($this->mediaRepository->checkIsExist($id) == false) {
            throw new NotFoundException("Media is not found");
        }
    }
}
