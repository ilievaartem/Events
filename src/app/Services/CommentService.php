<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Constants\DB\CommentDBConstants;
use App\Exceptions\AuthException;
use App\Exceptions\ForbiddenException;

class CommentService
{
    public function __construct(
        private CommentRepositoryInterface $commentRepository,
        private UserService $userService,
        private EventService $eventService,
    ) {
    }
    public function formatCommentForRecord(string $eventId, string $authorId, string $content): array
    {
        return [
            CommentDBConstants::EVENT_ID => $eventId,
            CommentDBConstants::AUTHOR_ID => $authorId,
            CommentDBConstants::CONTENT => $content
        ];
    }
    public function create(string $eventId, string $authorId, string $content): array
    {
        $this->eventService->checkIsExist($eventId);
        $this->userService->checkIsExist($authorId);
        return $this->commentRepository->create($this->formatCommentForRecord($eventId, $authorId, $content));
    }
    public function checkIsAuthor(string $id, string $userId): void
    {
        $this->checkIsExist($id);
        if ($this->commentRepository->checkIsExistCommentByAuthor($id, $userId) == false) {
            throw new ForbiddenException("Current user did not create that comment");
        }
    }
    public function getEventId(string $commentId): string
    {
        $this->checkIsExist($commentId);
        return $this->commentRepository->getEventId($commentId);
    }
    public function getAuthorId(string $commentId): string
    {
        $this->checkIsExist($commentId);
        return $this->commentRepository->getAuthorId($commentId);
    }
    public function show(string $id): ?array
    {
        $this->checkIsExist($id);
        return $this->commentRepository->show($id);
    }
    public function delete(string $id): bool
    {
        return $this->commentRepository->delete($id);
    }
    private function formatContentForRecord(string $content): array
    {
        return [
            CommentDBConstants::CONTENT => $content
        ];
    }
    public function update(string $content, string $id): array
    {
        $this->checkIsExist($id);
        $this->commentRepository->update($this->formatContentForRecord($content), $id);
        return $this->commentRepository->show($id);
    }
    public function getCommentsByAuthorId(string $authorId): array
    {
        $this->userService->checkIsExist($authorId);
        return $this->commentRepository->getCommentsByAuthorID($authorId);
    }
    public function getEventComments(string $eventId): array
    {
        $this->eventService->checkIsExist($eventId);
        return $this->commentRepository->getEventComments($eventId);
    }
    public function checkIsExist(string $id): void
    {
        if ($this->commentRepository->checkIsExist($id) == false) {
            throw new NotFoundException("Comment is not found");

        }
    }
}
