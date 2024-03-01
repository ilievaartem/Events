<?php

namespace App\Repositories\Interfaces;

interface ChatRepositoryInterface
{
    public function index(): array;

    public function insert(array $data): bool;

    public function create(array $data): array;

    public function getChatAuthorByChatId(string $chatId): ?string;
    public function getChatMemberByChatId(string $chatId): ?string;
    public function getAllAuthorChat(string $authorId): ?array;
    public function getAllMemberChat(string $memberId): ?array;

    public function delete(string $id): bool;

    public function update(array $data, string $id): bool;

    public function checkIsChatExist(string $eventId, string $authorId, string $memberId): bool;
    public function getChatWithAllMessages(string $chatId): array;

    public function show(int|string $id): ?array;
    public function checkIsChatExistById(string $chatId): bool;
    public function getChatId(string $eventId, string $authorId, string $memberId): ?string;


}
