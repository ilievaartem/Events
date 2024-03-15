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
    public function create(string $event_id, string $author_id, string $content): array
    {
        $comment = [
            CommentDBConstants::EVENT_ID => $event_id,
            CommentDBConstants::AUTHOR_ID => $author_id,
            CommentDBConstants::CONTENT => $content
        ];
        return $this->commentRepository->create($comment);
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
    public function index(): array
    {
        $index = $this->commentRepository->index();
        if ($index != null) {
            return $index;
        }
        throw new NotFoundException("Comments is not found");
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
    public function update(array $data, string $id): array
    {
        $this->checkIsExist($id);

        $this->commentRepository->update($data, $id);
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
