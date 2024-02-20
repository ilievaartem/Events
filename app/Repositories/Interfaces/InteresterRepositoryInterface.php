<?php

namespace App\Repositories\Interfaces;

interface InteresterRepositoryInterface
{
    public function index(): array;

    public function insert(array $data): bool;

    public function create(array $data): array;


    public function delete(string $id): bool;

    public function update(array $data, string $id): bool;


    public function show(string|int $id): ?array;
}
