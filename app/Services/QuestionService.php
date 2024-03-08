<?php

namespace App\Services;

use App\Constants\DB\QuestionDBConstants;
use App\Exceptions\AuthException;
use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\QuestionRepositoryInterface;

class QuestionService
{
    public function __construct(
        private QuestionRepositoryInterface $questionRepository,
        private EventService $eventService,
        private UserService $userService,
    ) {
    }
    public function index(): array
    {
        $index = $this->questionRepository->index();
        if ($index != null) {
            return $index;
        }
        throw new NotFoundException("Questions are not found");
    }
    public function show(string $id): ?array
    {
        $this->checkIsExist($id);
        return $this->questionRepository->show($id);
    }
    private function checkIsParentExist(?string $parentId): void
    {
        if ($parentId == null) {
            return;
        }
        $this->checkIsExist($parentId);
    }
    public function create(string $eventId, string $authorId, ?string $parentId, string $content): array
    {
        $this->eventService->checkIsExist($eventId);
        $this->userService->checkIsExist($authorId);
        $this->checkIsParentExist($parentId);
        $question = [
            QuestionDBConstants::EVENT_ID => $eventId,
            QuestionDBConstants::AUTHOR_ID => $authorId,
            QuestionDBConstants::PARENT_ID => $parentId,
            QuestionDBConstants::CONTENT => $content
        ];
        return $this->questionRepository->create($question);
    }
    public function delete(string $id): bool
    {
        return $this->questionRepository->delete($id);
    }
    public function update(array $data, string $id): array
    {
        $this->checkIsExist($id);
        $this->questionRepository->update($data, $id);
        return $this->questionRepository->show($id);
    }
    public function getQuestionsByAuthorId(string $id): array
    {
        return $this->questionRepository->getQuestionsByAuthorID($id);
    }
    public function checkIsAuthor(string $id, string $userId): void
    {
        $this->checkIsExist($id);
        if ($this->checkIsQuestionHasCurrentAuthorId($id, $userId) == false) {
            throw new AuthException("Current user did not create that question");
        }
    }
    public function checkIsQuestionHasCurrentAuthorId(string $eventId, string $authorId): bool
    {
        return $this->questionRepository->checkIsQuestionHasCurrentAuthorId($eventId, $authorId);
    }
    public function checkIsExist(string $id): void
    {
        if ($this->questionRepository->checkIsExist($id) == false) {
            throw new NotFoundException("Question is not found");
        }
    }
}
