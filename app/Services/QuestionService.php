<?php

namespace App\Services;

use App\Constants\DB\QuestionDBConstants;
use App\DTO\Question\CreateQuestionDTO;
use App\DTO\Question\ResponseToQuestionDTO;
use App\DTO\Question\UpdateQuestionDTO;
use App\Exceptions\AuthException;
use App\Exceptions\ConflictException;
use App\Exceptions\ForbiddenException;
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
    private function formatResponseToQuestion(ResponseToQuestionDTO $question): array
    {
        return [
            QuestionDBConstants::EVENT_ID => $question->getEventId(),
            QuestionDBConstants::AUTHOR_ID => $question->getAuthorId(),
            QuestionDBConstants::PARENT_ID => $question->getContent(),
            QuestionDBConstants::CONTENT => $question->getContent()
        ];
    }
    private function formatCreateQuestion(CreateQuestionDTO $question): array
    {
        return [
            QuestionDBConstants::EVENT_ID => $question->getEventId(),
            QuestionDBConstants::AUTHOR_ID => $question->getAuthorId(),
            QuestionDBConstants::CONTENT => $question->getContent()
        ];
    }
    private function formatUpdateQuestion(string $content): array
    {
        return [
            QuestionDBConstants::CONTENT => $content
        ];
    }
    public function createQuestion(CreateQuestionDTO $question): array
    {
        $this->eventService->checkIsExist($question->getEventId());
        return $this->questionRepository->create($this->formatCreateQuestion($question));
    }
    public function responseToQuestion(ResponseToQuestionDTO $question): array
    {
        $this->eventService->checkIsExist($question->getEventId());
        return $this->questionRepository->create($this->formatResponseToQuestion($question));
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
    private function checkIsUpdateAvailable(string $id): void
    {
        now()->diffInMinutes($this->questionRepository->getQuestionCreatedAt($id)) < 3 ?: throw new ConflictException("Time for update run out");
    }
    public function update(UpdateQuestionDTO $question): array
    {
        $this->checkIsExist($question->getQuestionId());
        $this->checkIsUpdateAvailable($question->getQuestionId());
        $this->questionRepository->update($this->formatUpdateQuestion($question->getContent()), $question->getQuestionId());
        return $this->questionRepository->show($question->getQuestionId());
    }
    public function getQuestionsByAuthorId(string $authorId): array
    {
        $this->userService->checkIsExist($authorId);
        return $this->questionRepository->getQuestionsByAuthorID($authorId);
    }
    public function getEventQuestions(string $eventId): array
    {
        $this->eventService->checkIsExist($eventId);
        return $this->questionRepository->getEventQuestions($eventId);
    }
    public function checkIsAuthor(string $id, string $userId): void
    {
        $this->checkIsExist($id);
        if ($this->checkIsQuestionHasCurrentAuthorId($id, $userId) == false) {
            throw new ForbiddenException("Current user did not create that question");
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
