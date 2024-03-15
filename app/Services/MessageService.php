<?php

namespace App\Services;

use App\Constants\DB\MessageDBConstants;
use App\DTO\Message\CreateMessageDTO;
use App\Exceptions\AuthException;
use App\Exceptions\BadRequestException;
use App\Exceptions\ConflictException;
use App\Exceptions\ForbiddenException;
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
    public function checkIsAuthor(string $id, string $userId): void
    {
        $this->checkIsExist($id);
        if ($this->messageRepository->checkIsExistMessageByAuthor($id, $userId) == false) {
            throw new ForbiddenException("Current user did not create that message");
        }
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
            throw new ForbiddenException("Receiver is equal to the responder");

        }
        if (
            $this->userService->checkIsUserDoesNotExistByUserId($receiverId)
        ) {
            throw new NotFoundException("Receiver does not found");

        }
        $this->eventService->checkIsExist($eventId);
        if (
            $this->eventService->checkIsEventHasNotCurrentAuthorId($eventId, $receiverId)
            && $this->eventService->checkIsEventHasNotCurrentAuthorId($eventId, $responderId)
        ) {
            throw new NotFoundException("Event has not current authors");
        }
    }
    public function create(CreateMessageDTO $message): array
    {
        $this->validateDataForCreate($message->getEventId(), $message->getReceiverId(), $message->getResponderId());
        $chatAuthorId = $this->eventService->getAuthorIdByEventId($message->getEventId());
        $chatAuthorId == $message->getReceiverId()
            ? $chatMemberId = $message->getResponderId()
            : $chatMemberId = $message->getReceiverId();
        $this->chatService->isChatExistForMembers($message->getEventId(), $chatAuthorId, $chatMemberId)
            ? $this->createNewMessage($chatMemberId, $chatAuthorId, $message->getText(), $message->getEventId(), $message->getResponderId())
            : $this->createNewChatAndMessage($chatMemberId, $chatAuthorId, $message->getText(), $message->getEventId(), $message->getResponderId());
        return [
            MessageDBConstants::CHAT_ID => $this->chatService->getChatId($message->getEventId(), $chatAuthorId, $chatMemberId),
            MessageDBConstants::TEXT => $message->getText(),
        ];
        ;
    }
    public function makeNewMessage(string $memberId, string $authorId, string $text, string $eventId, string $responderId): array
    {
        return [
            MessageDBConstants::CHAT_ID => $this->chatService->getChatId($eventId, $authorId, $memberId),
            MessageDBConstants::AUTHOR_ID => $responderId,
            MessageDBConstants::TEXT => $text,
        ];
    }
    public function createNewMessage(string $memberId, string $authorId, string $text, string $eventId, string $responderId): void
    {
        $this->messageRepository->create($this->makeNewMessage($memberId, $authorId, $text, $eventId, $responderId));
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
        $this->messageRepository->create($this->makeNewMessage($memberId, $authorId, $text, $eventId, $lastMessageAuthorId));

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
    private function checkIsUpdateAvailable(string $id): void
    {
        now()->diffInMinutes($this->messageRepository->getMessageCreatedAt($id)) < 3 ?: throw new ConflictException("Time for update run out");
    }
    public function checkIsExist(string $id): void
    {
        if ($this->messageRepository->checkIsExist($id) == false) {
            throw new NotFoundException("Message is not found");
        }
    }
}
