<?php

namespace App\Repositories\Interfaces;

interface MediaRepositoryInterface
{
    public function index(): array;

    public function insert(array $data): bool;

    public function create(array $data): array;

    public function getPhotoPathById(string $id): ?string;
    public function getPhotoTypeById(string $id): string;
    public function updatePhoto(string $id, string $photoPath, string $photoExtension): bool;

    public function delete(string $id): bool;

    public function update(array $data, string $id): bool;


    public function show(string|int $id): ?array;
}
