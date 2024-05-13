<?php

namespace App\Repositories\Interfaces;



interface EventRepositoryInterface extends BaseRepositoryInterface
{

    public function checkIsEventHasCurrentAuthorId(string $eventId, string $authorId): bool;
    public function getAuthorIdByEventId(string $eventId): ?string;
    public function getSimilarEvents(array $events): array;
    public function getInfoForSimilar(string $id): array;
    public function addTagsIds(string $id, array $tagsIds): void;
    public function getTopicById(string $id): ?string;
    public function getEventsByAuthorID(string $userId): array;
    public function getEventWithOtherData(string $id): array;
    public function getEventsWithRelations(): array;
    public function addCategoriesIds(string $id, array $categoriesIds): void;

    public function updatePhotos(string $id, array $photosPaths): bool;
    public function updateMainPhoto(string $id, ?string $mainPhotoPath): bool;
    public function getEventPhotosById(string $id): ?array;
    public function getEventMainPhotoById(string $id): ?string;

    public function searchEvent(?string $title, ?string $description): ?array;

}
