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
use App\Services\System\CRUDService;

class MessageService extends CrudService
{
    public function __construct(
        MessageRepositoryInterface $repository,
        private EventService       $eventService,
        private ChatService        $chatService,
        private UserService        $userService,
    )
    {
        parent::__construct($repository);
    }

    /**
     * @return array
     * @throws NotFoundException
     */
    public function showAll(): array
    {
        $index = $this->repository->index();
        if ($index != null) {
            return $index;
        }
        throw new NotFoundException("Messages are not found");
    }

    /**
     * @return array
     */
    public function showMessages(): array
    {
        return $this->repository->getMessages();
    }

    /**
     * @param string $id
     * @param string $userId
     * @return void
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function checkIsAuthor(string $id, string $userId): void
    {
        $this->checkIsExist($id);
        if ($this->repository->checkIsExistMessageByAuthor($id, $userId) == false) {
            throw new ForbiddenException("Current user did not create that message");
        }
    }

    /**
     * @param string $receiverId
     * @param string $responderId
     * @return bool
     */
    private function checkIsReceiverEqualToResponder(string $receiverId, string $responderId): bool
    {
        return $receiverId == $responderId ? true : false;
    }

    /**
     * @param string $eventId
     * @param string $receiverId
     * @param string $responderId
     * @return void
     * @throws ForbiddenException
     * @throws NotFoundException
     */
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

    /**
     * @param CreateMessageDTO $message
     * @param string $chatAuthorId
     * @return string
     */
    private function getChatMemberId(CreateMessageDTO $message, string $chatAuthorId): string
    {
        return $chatAuthorId == $message->getReceiverId()
            ? $chatMemberId = $message->getResponderId()
            : $chatMemberId = $message->getReceiverId();
    }

    /**
     * @param CreateMessageDTO $message
     * @param string $chatMemberId
     * @param string $chatAuthorId
     * @return array
     */
    private function createMessageAndChatIfNotExist(CreateMessageDTO $message, string $chatMemberId, string $chatAuthorId): array
    {
        return $this->chatService->isChatExistForMembers($message->getEventId(), $chatAuthorId, $chatMemberId)
            ? $this->createNewMessage($chatMemberId, $chatAuthorId, $message->getText(), $message->getEventId(), $message->getResponderId())
            : $this->createNewChatAndMessage($chatMemberId, $chatAuthorId, $message->getText(), $message->getEventId(), $message->getResponderId());

    }

    /**
     * @param CreateMessageDTO $message
     * @return array
     * @throws ForbiddenException
     * @throws NotFoundException
     */
    public function create(CreateMessageDTO $message): array
    {
        $this->validateDataForCreate($message->getEventId(), $message->getReceiverId(), $message->getResponderId());
        $chatAuthorId = $this->eventService->getAuthorIdByEventId($message->getEventId());
        $chatMemberId = $this->getChatMemberId($message, $chatAuthorId);
        return $this->createMessageAndChatIfNotExist($message, $chatMemberId, $chatAuthorId);
    }

    /**
     * @param string $memberId
     * @param string $authorId
     * @param string $text
     * @param string $eventId
     * @param string $responderId
     * @return array
     */
    public function makeNewMessage(string $memberId, string $authorId, string $text, string $eventId, string $responderId): array
    {
        return [
            MessageDBConstants::CHAT_ID => $this->chatService->getChatId($eventId, $authorId, $memberId),
            MessageDBConstants::AUTHOR_ID => $responderId,
            MessageDBConstants::TEXT => $text,
        ];
    }

    /**
     * @param string $memberId
     * @param string $authorId
     * @param string $text
     * @param string $eventId
     * @param string $responderId
     * @return array
     */
    public function createNewMessage(string $memberId, string $authorId, string $text, string $eventId, string $responderId): array
    {
        $this->chatService->updateLastMessageTextAndAuthor(
            $text,
            $authorId,
            $this->chatService->getChatId($eventId, $authorId, $memberId)
        );
        return $this->repository->create($this->makeNewMessage($memberId, $authorId, $text, $eventId, $responderId));

    }

    /**
     * @param string $memberId
     * @param string $authorId
     * @param string $text
     * @param string $eventId
     * @param string $lastMessageAuthorId
     * @return array
     */
    public function createNewChatAndMessage(
        string $memberId,
        string $authorId,
        string $text,
        string $eventId,
        string $lastMessageAuthorId
    ): array
    {
        $this->chatService->makeNewChat($authorId, $eventId, $memberId, $text, $lastMessageAuthorId);
        return $this->repository->create($this->makeNewMessage($memberId, $authorId, $text, $eventId, $lastMessageAuthorId));

    }

    /**
     * @param string $text
     * @param string $id
     * @return array
     * @throws ConflictException
     * @throws NotFoundException
     */
    public function update(string $text, string $id): array
    {
        $this->checkIsExist($id);
        $this->checkIsUpdateAvailable($id);
        $this->repository->update($this->formatForUpdate($text), $id);
        return $this->repository->show($id);
    }

    /**
     * @param string $text
     * @return string[]
     */
    private function formatForUpdate(string $text): array
    {
        return [
            MessageDBConstants::TEXT => $text
        ];
    }

    /**
     * @param string $id
     * @return void
     * @throws ConflictException
     */
    private function checkIsUpdateAvailable(string $id): void
    {
        now()->diffInMinutes($this->repository->getMessageCreatedAt($id)) < 3 ?: throw new ConflictException("Time for update run out");
    }

    /**
     * @param string $id
     * @return void
     * @throws NotFoundException
     */
    public function checkIsExist(string $id): void
    {
        if ($this->repository->checkIsExist($id) == false) {
            throw new NotFoundException("Message is not found");
        }
    }
}
