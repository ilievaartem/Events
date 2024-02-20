<?php

namespace App\Repositories\Interfaces;

interface CommentRepositoryInterface
{

    public function index(): array;


    public function create(array $data): array;
    public function insert(array $data): bool;
    public function getEventId(string $id): string;
    public function getAuthorId(string $id): string;


    public function delete(string $id): bool;

    public function update(array $data, string $id): bool;


    public function show(string|int $id): ?array;


}
