<?php

namespace App\Services;

use App\Constants\DB\MessageDBConstants;
use App\Exceptions\BadRequestException;
use App\Exceptions\ConflictException;
use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\MessageRepositoryInterface;

class MessageService
{
    public function __construct(
        private MessageRepositoryInterface $messageRepository,
        private EventService $eventService,
        private ChatService $chatService,
        private UserService $userService,
    ) {

    }
    public function index(): array
    {
        $index = $this->messageRepository->index();
        if ($index != null) {
            return $index;
        }
        throw new NotFoundException("Messages are not found");
    }
    public function show(string $id): ?array
    {
        $this->checkIsExist($id);
        return $this->messageRepository->show($id);
    }
    private function checkIsReceiverEqualToResponder(string $receiverId, string $responderId): bool
    {
        return $receiverId == $responderId ? true : false;
    }
    private function validateDataForCreate(string $eventId, string $receiverId, string $responderId): void
    {
        if (
            $this->checkIsReceiverEqualToResponder($receiverId, $responderId)
        ) {
            throw new BadRequestException("Receiver is equal to the responder");

        }
        if (
            $this->userService->checkIsUserDoesNotExistByUserId($receiverId)
        ) {
            throw new NotFoundException("Receiver does not found");

        }
        if (
            $this->eventService->checkIsEventDoesNotExistByEventId($eventId)
        ) {
            throw new NotFoundException("Event does not found");
        }
        if (
            $this->eventService->checkIsEventHasNotCurrentAuthorId($eventId, $receiverId)
            && $this->eventService->checkIsEventHasNotCurrentAuthorId($eventId, $responderId)
        ) {
            throw new NotFoundException("Event has not current authors");
        }
    }
    public function create(string $eventId, string $receiverId, string $responderId, string $text): array
    {


        $this->validateDataForCreate($eventId, $receiverId, $responderId);
        $chatAuthorId = $this->eventService->getAuthorIdByEventId($eventId);
        $chatAuthorId == $receiverId
            ? $chatMemberId = $responderId
            : $chatMemberId = $receiverId;
        $this->chatService->checkIsChatExist($eventId, $chatAuthorId, $chatMemberId)
            ? $this->createNewMessage($chatMemberId, $chatAuthorId, $text, $eventId)
            : $this->createNewChatAndMessage($chatMemberId, $chatAuthorId, $text, $eventId, $responderId);
        return [
            MessageDBConstants::CHAT_ID => $this->chatService->getChatId($eventId, $chatAuthorId, $chatMemberId),
            MessageDBConstants::TEXT => $text,
        ];
        ;



    }
    public function makeNewMessage(string $memberId, string $authorId, string $text, string $eventId): array
    {
        return [
            MessageDBConstants::CHAT_ID => $this->chatService->getChatId($eventId, $authorId, $memberId),
            MessageDBConstants::AUTHOR_ID => $memberId,
            MessageDBConstants::TEXT => $text,
        ];
    }
    public function createNewMessage(string $memberId, string $authorId, string $text, string $eventId): void
    {
        $this->messageRepository->create($this->makeNewMessage($memberId, $authorId, $text, $eventId));
        $this->chatService->updateLastMessageTextAndAuthor(
            $text,
            $authorId,
            $this->chatService->getChatId($eventId, $authorId, $memberId)
        );
    }
    public function createNewChatAndMessage(
        string $memberId,
        string $authorId,
        string $text,
        string $eventId,
        string $lastMessageAuthorId
    ): void {
        $this->chatService->makeNewChat($authorId, $eventId, $memberId, $text, $lastMessageAuthorId);
        $this->messageRepository->create($this->makeNewMessage($memberId, $authorId, $text, $eventId));

    }
    public function delete(string $id): bool
    {
        return $this->messageRepository->delete($id);
    }
    public function update(string $text, string $id): array
    {
        $this->checkIsExist($id);
        $this->checkIsUpdateAvailable($id);
        $this->messageRepository->update($this->formatForUpdate($text), $id);
        return $this->messageRepository->show($id);
    }
    private function formatForUpdate(string $text): array
    {
        return [
            MessageDBConstants::TEXT => $text
        ];
    }
    public function getMessageCreatedAt(string $id): string
    {
        return $this->messageRepository->getMessageCreatedAt($id);
    }
    private function checkIsUpdateAvailable(string $id): void
    {
        now()->diffInMinutes($this->getMessageCreatedAt($id)) < 3 ?: throw new ConflictException("Time for update run out");
    }
    public function checkIsExist(string $id): void
    {
        if ($this->messageRepository->checkIsExist($id) == false) {
            throw new NotFoundException("Message is not found");
        }
    }
}
