<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Constants\DB\CommentDBConstants;
use App\Exceptions\AuthException;

class CommentService
{
    public function __construct(private CommentRepositoryInterface $commentRepository)
    {
        $this->commentRepository = $commentRepository;
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
            throw new AuthException("Current user did not create that comment");
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
    public function getCommentsByAuthorId(string $id): array
    {
        return $this->commentRepository->getCommentsByAuthorID($id);
    }
    public function checkIsExist(string $id): void
    {
        if ($this->commentRepository->checkIsExist($id) == false) {
            throw new NotFoundException("Comment is not found");

        }
    }
}
