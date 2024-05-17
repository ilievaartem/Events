<?php

namespace App\Services;

use App\Constants\DB\CommentDBConstants;
use App\DTO\Comment\CreateCommentDTO;
use App\Exceptions\ForbiddenException;
use App\Exceptions\NotFoundException;
use App\Repositories\CommentRepository;
use App\Repositories\Interfaces\CommentRepositoryInterface;
use App\Services\System\CRUDService;

class CommentService extends CRUDService
{
    public function __construct(
        CommentRepositoryInterface    $repository,
        private readonly UserService  $userService,
        private readonly EventService $eventService,
    )
    {
        /** @var CommentRepository $repository */
        $this->repository = $repository;
        parent::__construct($repository);
    }

    /**
     * @return array
     */
    public function showComments(): array
    {
        return $this->repository->getComments();
    }

    /**
     * @param CreateCommentDTO $createCommentDTO
     * @return array
     */
    public function formatCommentForRecord(CreateCommentDTO $createCommentDTO): array
    {
        return [
            CommentDBConstants::EVENT_ID => $createCommentDTO->getEventId(),
            CommentDBConstants::AUTHOR_ID => $createCommentDTO->getAuthorId(),
            CommentDBConstants::CONTENT => $createCommentDTO->getContent()
        ];
    }

    /**
     * @param CreateCommentDTO $createCommentDTO
     * @return array
     * @throws NotFoundException
     */
    public function create(CreateCommentDTO $createCommentDTO): array
    {
        $this->eventService->checkIsExist($createCommentDTO->getEventId());
        $this->userService->checkIsExist($createCommentDTO->getAuthorId());

        return $this->repository->create($this->formatCommentForRecord($createCommentDTO));
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
        if (!$this->repository->checkIsExistCommentByAuthor($id, $userId)) {
            throw new ForbiddenException("Current user did not create that comments");
        }
    }

    /**
     * @param string $commentId
     * @return string
     * @throws NotFoundException
     */
    public function getEventId(string $commentId): string
    {
        $this->checkIsExist($commentId);
        return $this->repository->getEventId($commentId);
    }

    /**
     * @param string $commentId
     * @return string
     * @throws NotFoundException
     */
    public function getAuthorId(string $commentId): string
    {
        $this->checkIsExist($commentId);
        return $this->repository->getAuthorId($commentId);
    }

    /**
     * @param string $id
     * @return array
     */
    public function showCommentsOfEvent(string $id): array
    {
        return $this->repository->getCommentsByEvent($id);
    }

    /**
     * @param string $content
     * @return string[]
     */
    private function formatContentForRecord(string $content): array
    {
        return [
            CommentDBConstants::CONTENT => $content
        ];
    }

    /**
     * @param string $content
     * @param string $id
     * @return array
     * @throws NotFoundException
     */
    public function update(string $content, string $id): array
    {
        $this->checkIsExist($id);
        $this->repository->update($this->formatContentForRecord($content), $id);
        return $this->repository->show($id);
    }

    /**
     * @param string $authorId
     * @return array
     * @throws NotFoundException
     */
    public function getCommentsByAuthorId(string $authorId): array
    {
        $this->userService->checkIsExist($authorId);
        return $this->repository->getCommentsByAuthorID($authorId);
    }

    /**
     * @param string $eventId
     * @return array
     * @throws NotFoundException
     */
    public function getEventComments(string $eventId): array
    {
        $this->eventService->checkIsExist($eventId);
        return $this->repository->getEventComments($eventId);
    }

    /**
     * @param string $id
     * @return void
     * @throws NotFoundException
     */
    public function checkIsExist(string $id): void
    {
        if (!$this->repository->checkIsExist($id)) {
            throw new NotFoundException("Comment is not found");
        }
    }
}
