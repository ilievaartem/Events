<?php

namespace App\Services;

use App\Constants\DB\QuestionDBConstants;
use App\DTO\Question\AnswerQuestionDTO;
use App\DTO\Question\CreateQuestionDTO;
use App\DTO\Question\ResponseToQuestionDTO;
use App\DTO\Question\UpdateQuestionDTO;
use App\Exceptions\ConflictException;
use App\Exceptions\ForbiddenException;
use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\QuestionRepositoryInterface;
use App\Repositories\QuestionRepository;
use App\Services\System\CRUDService;

class QuestionService extends CRUDService
{
    public function __construct(
        QuestionRepositoryInterface $repository,
        private EventService        $eventService,
        private UserService         $userService,
    )
    {
        /** @var QuestionRepository $repository */
        $this->repository = $repository;
        parent::__construct($repository);
    }

    /**
     * @param string $id
     * @return array
     */
    public function showQuestionsOfEvent(string $id): array
    {
        return $this->repository->getQuestionsByEvent($id);
    }

    /**
     * @return array
     */
    public function showQuestions(): array
    {
        return $this->repository->getQuestions();
    }

    /**
     * @param AnswerQuestionDTO $question
     * @return array
     */
    private function formatResponseToQuestion(AnswerQuestionDTO $question): array
    {
        return [
            QuestionDBConstants::EVENT_ID => $question->getEventId(),
            QuestionDBConstants::AUTHOR_ID => $question->getAuthorId(),
            QuestionDBConstants::PARENT_ID => $question->getParentId(),
            QuestionDBConstants::CONTENT => $question->getContent()
        ];
    }

    /**
     * @param CreateQuestionDTO $question
     * @return array
     */
    private function formatCreateQuestion(CreateQuestionDTO $question): array
    {
        return [
            QuestionDBConstants::EVENT_ID => $question->getEventId(),
            QuestionDBConstants::AUTHOR_ID => $question->getAuthorId(),
            QuestionDBConstants::CONTENT => $question->getContent()
        ];
    }

    /**
     * @param string $content
     * @return string[]
     */
    private function formatUpdateQuestion(string $content): array
    {
        return [
            QuestionDBConstants::CONTENT => $content
        ];
    }

    /**
     * @param CreateQuestionDTO $question
     * @return array
     * @throws NotFoundException
     */
    public function createQuestion(CreateQuestionDTO $question): array
    {
        $this->eventService->checkIsExist($question->getEventId());
        return $this->repository->create($this->formatCreateQuestion($question));
    }

    /**
     * @param AnswerQuestionDTO $question
     * @return array
     * @throws NotFoundException
     */
    public function answerToQuestion(AnswerQuestionDTO $question): array
    {
        $this->eventService->checkIsExist($question->getEventId());
        $this->checkIsExist($question->getParentId());
        return $this->repository->create($this->formatResponseToQuestion($question));
    }

    /**
     * @param string $id
     * @return void
     * @throws ConflictException
     */
    private function checkIsUpdateAvailable(string $id): void
    {
        now()->diffInMinutes($this->repository->getQuestionCreatedAt($id)) < 3 ?: throw new ConflictException("Time for update run out");
    }

    /**
     * @param UpdateQuestionDTO $question
     * @return array
     * @throws ConflictException
     * @throws NotFoundException
     */
    public function update(UpdateQuestionDTO $question): array
    {
        $this->checkIsExist($question->getQuestionId());
        $this->checkIsUpdateAvailable($question->getQuestionId());
        $this->repository->update($this->formatUpdateQuestion($question->getContent()), $question->getQuestionId());
        return $this->repository->show($question->getQuestionId());
    }

    /**
     * @param string $authorId
     * @return array
     * @throws NotFoundException
     */
    public function getQuestionsByAuthorId(string $authorId): array
    {
        $this->userService->checkIsExist($authorId);
        return $this->repository->getQuestionsByAuthorID($authorId);
    }

    /**
     * @param string $eventId
     * @return array
     * @throws NotFoundException
     */
    public function getEventQuestions(string $eventId): array
    {
        $this->eventService->checkIsExist($eventId);
        return $this->repository->getEventQuestions($eventId);
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
        if ($this->checkIsQuestionHasCurrentAuthorId($id, $userId) == false) {
            throw new ForbiddenException("Current user did not create that question");
        }
    }

    /**
     * @param string $eventId
     * @param string $authorId
     * @return bool
     */
    public function checkIsQuestionHasCurrentAuthorId(string $eventId, string $authorId): bool
    {
        return $this->repository->checkIsQuestionHasCurrentAuthorId($eventId, $authorId);
    }

    /**
     * @param string $id
     * @return void
     * @throws NotFoundException
     */
    public function checkIsExist(string $id): void
    {
        if (!$this->repository->checkIsExist($id)) {
            throw new NotFoundException("Question is not found");
        }
    }
}
