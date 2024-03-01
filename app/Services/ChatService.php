<?php

namespace App\Services;

use App\Constants\DB\ChatDBConstants;
use App\Constants\DB\MessageDBConstants;
use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\ChatRepositoryInterface;

class ChatService
{
    public function __construct(
        private ChatRepositoryInterface $chatRepository,
        private EventService $eventService
    ) {

    }
    public function index(): array
    {
        $index = $this->chatRepository->index();
        if ($index != null) {
            return $index;
        }
        throw new NotFoundException("Chats are not found");
    }
    public function show(string $id): ?array
    {
        $show = $this->chatRepository->show($id);
        if ($show != null) {
            return $show;
        }
        throw new NotFoundException("Chat is not found");
    }
    public function create(string $topic, string $authorId, string $memberId, string $lastMessageText, string $lastMessageAuthorId): ?array
    {
        $chat = [
            ChatDBConstants::TOPIC => $topic,
            ChatDBConstants::AUTHOR_ID => $authorId,
            ChatDBConstants::MEMBER_ID => $memberId,
            ChatDBConstants::LAST_MESSAGE_TEXT => $lastMessageText,
            ChatDBConstants::LAST_MESSAGE_AUTHOR_ID => $lastMessageAuthorId,
        ];
        return $this->chatRepository->create($chat);
    }
    public function makeNewChat(
        string $authorId,
        string $eventId,
        string $memberId,
        string $lastMessageText,
        string $lastMessageAuthorId
    ): array {
        $chat = [
            ChatDBConstants::TOPIC => $this->eventService->getTopicById($eventId),
            ChatDBConstants::AUTHOR_ID => $authorId,
            ChatDBConstants::EVENT_ID => $eventId,
            ChatDBConstants::MEMBER_ID => $memberId,
            ChatDBConstants::LAST_MESSAGE_TEXT => $lastMessageText,
            ChatDBConstants::LAST_MESSAGE_AUTHOR_ID => $lastMessageAuthorId,
        ];
        return $this->chatRepository->create($chat);

    }

    public function updateLastMessageTextAndAuthor(
        string $lastMessageText,
        string $lastMessageAuthorId,
        string $chatId
    ): bool {
        $dataForUpdate = [
            ChatDBConstants::LAST_MESSAGE_TEXT => $lastMessageText,
            ChatDBConstants::LAST_MESSAGE_AUTHOR_ID => $lastMessageAuthorId,
        ];
        return $this->chatRepository->update($dataForUpdate, $chatId);
    }
    public function delete(string $id): bool
    {
        return $this->chatRepository->delete($id);
    }
    public function checkIsChatExistById(string $chatId): bool
    {
        return $this->chatRepository->checkIsChatExistById($chatId);
    }
    public function getChatId(string $eventId, string $authorId, string $memberId): ?string
    {
        return $this->chatRepository->getChatId($eventId, $authorId, $memberId);
    }
    public function checkIsChatExist(string $eventId, string $authorId, string $memberId): bool
    {
        return $this->chatRepository->checkIsChatExist($eventId, $authorId, $memberId);
    }
    public function update(array $data, string $id): array
    {
        $this->chatRepository->update($data, $id);
        return $this->chatRepository->show($id);
    }
    public function getChatAuthorByChatId(string $chatId): ?string
    {
        return $this->chatRepository->getChatAuthorByChatId($chatId);
    }
    public function getChatMemberByChatId(string $chatId): ?string
    {
        return $this->chatRepository->getChatMemberByChatId($chatId);
    }
    public function getChatWithAllMessages(string $chatId): array
    {
        $getById = $this->checkIsChatExistById($chatId);
        if ($getById != null) {
            return $this->makeResponseForChatWithAllMessages(
                $chatId,
                $this->chatRepository->getChatWithAllMessages($chatId)
            );
        }
        throw new NotFoundException("Chat is not found");
    }
    public function getAllAuthorChat(string $authorId): ?array
    {
        return $this->chatRepository->getAllAuthorChat($authorId);
    }
    public function getAllMemberChat(string $memberId): ?array
    {
        return $this->chatRepository->getAllMemberChat($memberId);
    }
    private function makeResponseForChatWithAllMessages(string $chatId, array $chatsWithMessages): array
    {
        $chatsWithMessages[ChatDBConstants::AUTHOR_ID] = $this->getChatAuthorByChatId($chatId);
        $chatsWithMessages[ChatDBConstants::MEMBER_ID] = $this->getChatMemberByChatId($chatId);
        return $chatsWithMessages;
    }
}
