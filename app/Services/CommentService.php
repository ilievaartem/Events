<?php

namespace App\Services;

use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Constants\DB\CommentDBConstants;

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
    public function getEventId(string $commentId): string
    {
        return $this->commentRepository->getEventId($commentId);
    }
    public function getAuthorId(string $commentId): string
    {
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
        $show = $this->commentRepository->show($id);
        if ($show != null) {
            return $show;
        }
        throw new NotFoundException("Comment is not found");
    }
    public function delete(string $id): bool
    {
        return $this->commentRepository->delete($id);
    }
    public function update(array $data, string $id): array
    {
        $this->commentRepository->update($data, $id);
        return $this->commentRepository->show($id);
    }
}
