<?php

namespace App\Repositories\Interfaces;

use App\DTO\Contracts\DTOContract;
use App\DTO\Event\FilterEventDTO;

interface EventRepositoryInterface
{
    public function index(): array;


    public function create(array $data): array;

    public function insert(array $data): bool;

    public function delete(string $id): bool;

    public function update(array $data, string $id): bool;

    public function show(int|string $id): ?array;
    public function checkIsEventExistByEventId(string $eventId): bool;
    public function checkIsEventHasCurrentAuthorId(string $eventId, string $authorId): bool;
    public function getAuthorIdByEventId(string $eventId): ?string;


    public function getTopicById(string $id): ?string;

    public function updatePhotos(string $id, array $photosPaths): bool;
    public function updateMainPhoto(string $id, string $mainPhotoPath): bool;
    public function getEventPhotosById(string $id): ?array;
    public function getEventMainPhotoById(string $id): ?string;

    public function searchEvent(?string $title, ?string $description): ?array;


}
