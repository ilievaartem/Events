<?php

namespace App\Services;

use App\Constants\DB\MediaDBConstants;
use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\MediaRepositoryInterface;
use Ramsey\Uuid\Uuid;

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
        $show = $this->mediaRepository->show($id);
        if ($show != null) {
            return $show;
        }
        throw new NotFoundException("Media is not found");
    }
    public function create(string $commentId, string $photo, string $photoExtension): array
    {
        $photoPath = $this->photoService->makeMainPhotoDirectoryNameForMedia($commentId, $photoExtension);
        $eventId = $this->commentService->getEventId($commentId);
        $authorId = $this->commentService->getAuthorId($commentId);
        $media = [
            MediaDBConstants::PATH => $photoPath,
            MediaDBConstants::TYPE => $photoExtension,
            MediaDBConstants::EVENT_ID => $eventId,
            MediaDBConstants::AUTHOR_ID => $authorId,
            MediaDBConstants::COMMENT_ID => $commentId,

        ];
        $this->photoService->loadPhoto($photo, $photoPath);

        return $this->mediaRepository->create($media);

    }
    public function delete(string $id): bool
    {
        return $this->mediaRepository->delete($id);
    }

    public function updatePhoto(string $id, ?string $photo, string $photoExtension): array
    {
        $alreadyExistedPhotosPaths = $this->mediaRepository->getPhotoPathById($id);
        $photoPath = $this->photoService->makeMainPhotoDirectoryNameForMedia($id, $photoExtension);
        $this->mediaRepository->updatePhoto($id, $photoPath, $photoExtension);
        $this->photoService->loadPhoto($photo, $photoPath);
        $this->photoService->deleteOldPhoto($alreadyExistedPhotosPaths);
        return $this->mediaRepository->show($id);
    }
}
