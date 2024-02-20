<?php

namespace App\Repositories\Interfaces;

interface UserRepositoryInterface
{
    public function index(): array;

    public function insert(array $data): bool;

    public function create(array $data): array;


    public function delete(string $id): bool;

    public function update(array $data, int $id): bool;

    public function getPhotoPathById(string $id): ?string;
    public function updatePhoto(string $id, string $photoPath): bool;

    public function show(string|int $id): ?array;
    public function userEvents(string $id): ?array;


    public function searchByName(string $name): ?int;
}
