<?php

namespace App\Repositories\Interfaces;

interface ChatRepositoryInterface extends BaseRepositoryInterface
{


    public function getChatAuthorByChatId(string $chatId): ?string;
    public function getChatMemberByChatId(string $chatId): ?string;
    public function getAllAuthorChat(string $authorId): ?array;
    public function getAllMemberChat(string $memberId): ?array;



    public function checkIsChatExist(string $eventId, string $authorId, string $memberId): bool;
    public function getChatWithAllMessages(string $chatId): array;

    public function getChatId(string $eventId, string $authorId, string $memberId): ?string;


}
