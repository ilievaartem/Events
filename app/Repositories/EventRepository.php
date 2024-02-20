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
    public function filterEvents(?string $phrase, ?array $categoriesIds, ?array $tagsIds, ?int $priceMax, ?int $priceMin, ?float $ratingMax, ?float $ratingMin): array
    {

        return Event::query()->when($phrase != null, function ($query) use ($phrase) {
            return $query->where(EventDBConstants::TITLE, $phrase)->whereOr(EventDBConstants::DESCRIPTION, $phrase);
        })
            // ->when($priceMax != null && $priceMin != null, function ($query) use ($priceMin, $priceMax) {
            //     return $query->whereBetween(EventDBConstants::PRICE, [$priceMin, $priceMax]);
            // })
            ->when($ratingMax != null && $ratingMin != null, function ($query) use ($ratingMax, $ratingMin) {
                return $query->whereBetween(EventDBConstants::RATING, [$ratingMin, $ratingMax]);
            })->when($categoriesIds != null, function ($query) use ($categoriesIds) {
                return $query->orWhereJsonContains(EventDBConstants::CATEGORIES_IDS, $categoriesIds);
            })->when($tagsIds != null, function ($query) use ($tagsIds) {
                return $query->orWhereJsonContains(EventDBConstants::TAGS_IDS, $tagsIds);
            })
            ->get()->toArray();
    }

}
