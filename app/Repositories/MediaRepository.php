<?php

namespace App\Repositories;

use App\Constants\DB\MediaDBConstants;
use App\Models\Media;
use App\Repositories\Interfaces\MediaRepositoryInterface;

class MediaRepository extends BaseRepository implements MediaRepositoryInterface
{
    public function getMediaByCommentId(string $commentId): array
    {
        return Media::query()->where(MediaDBConstants::COMMENT_ID, $commentId)->paginate(self::PER_PAGE)->toArray();
    }

    public function checkIsExistByCommentId(string $commentId): bool
    {
        return Media::query()->where(MediaDBConstants::COMMENT_ID, $commentId)->exists();
    }
    public function getPhotoPathById(string $id): string
    {
        return Media::query()->where(MediaDBConstants::ID, $id)->value(MediaDBConstants::PATH);
    }
    public function updatePhoto(string $id, string $photoPath, string $photoExtension): bool
    {
        return Media::query()->where(MediaDBConstants::ID, $id)->update([
            MediaDBConstants::PATH => $photoPath,
            MediaDBConstants::TYPE => $photoExtension
        ]);
    }

}
