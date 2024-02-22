<?php

namespace App\Repositories\Interfaces;

interface CategoryRepositoryInterface
{
    public function index(): array;


    public function create(array $data): array;


    public function delete(int $id): bool;

    public function update(array $data, int $id): bool;


    public function show(int|string $id): ?array;


}
