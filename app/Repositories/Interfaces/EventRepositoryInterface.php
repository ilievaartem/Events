<?php

namespace App\Repositories\Interfaces;

use App\DTO\Contracts\DTOContract;

interface EventRepositoryInterface
{
    public function index(): array;


    public function create(array $data): array;

    public function insert(array $data): bool;

    public function delete(string $id): bool;

    public function update(array $data, string $id): bool;

    public function show(string|int $id): ?array;
    public function updatePhotos(string $id, string $mainPhotoPath, array $photosPaths): bool;
    public function getAllPhotosById(string $id): ?array;
    public function searchEvent(?string $title, ?string $description): ?array;
    public function filterEvents(?string $phrase, ?array $categoriesIds, ?array $tagsIds, ?int $priceMax, ?int $priceMin, ?float $ratingMax, ?float $ratingMin): ?array;

}
