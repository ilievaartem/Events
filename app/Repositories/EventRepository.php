<?php

namespace App\Repositories;

use App\Models\Event;
use App\Repositories\Interfaces\EventRepositoryInterface;
use App\Constants\DB\EventDBConstants;
use App\Constants\DB\CommentDBConstants;
use App\Constants\DB\ColorDBConstants;
use App\Constants\DB\ManufacturerDBConstants;
use App\DTO\Contracts\DTOContract;
use App\DTO\Event\CreateEventDTO;
use App\DTO\Event\FilterEventDTO;
use Illuminate\Database\Eloquent\Builder;

class EventRepository extends BaseRepository implements EventRepositoryInterface
{
    private const PER_PAGE = 10;

    public function getByIdWithComments(int $id): array
    {
        return Event::with([
            CommentDBConstants::TABLE => function ($query) {
                $query->paginate(self::PER_PAGE);
            }
        ])->find($id)->toArray();
    }
    public function getAllPhotosById(string $id): ?array
    {
        return Event::query()->select(['photos', 'main_photo'])->find($id)->toArray();
    }

    public function updatePhotos(string $id, string $mainPhotoPath, array $photosPaths): bool
    {
        return Event::query()->where('id', $id)->update([
            'main_photo' => $mainPhotoPath,
            'photos' => $photosPaths
        ]);
    }
    public function searchEvent(?string $title, ?string $description): array
    {
        return Event::when($title != null, function ($query) use ($title) {
            return $query->where(EventDBConstants::TITLE, $title);
        })->when($description != null, function ($query) use ($description) {
            return $query->where(EventDBConstants::DESCRIPTION, $description);
        })->get()->toArray();
    }


}
