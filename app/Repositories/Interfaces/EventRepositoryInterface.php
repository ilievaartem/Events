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
    public function updatePhotos(string $id, string $mainPhotoPath, array $photosPaths): bool;
    public function getAllPhotosById(string $id): ?array;
    public function searchEvent(?string $title, ?string $description): ?array;
    public function filterEvents(FilterEventDTO $filterEventDTO): ?array;


}
