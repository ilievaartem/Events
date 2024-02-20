<?php

namespace App\Services;

use App\Constants\DB\QuestionDBConstants;
use App\Exceptions\NotFoundException;
use App\Repositories\Interfaces\QuestionRepositoryInterface;

class QuestionService
{
    public function __construct(private QuestionRepositoryInterface $questionRepository)
    {

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
        $show = $this->questionRepository->show($id);
        if ($show != null) {
            return $show;
        }
        throw new NotFoundException("Question is not found");
    }
    public function create(string $eventId, string $authorId, ?string $parentId, string $content): array
    {
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
        $this->questionRepository->update($data, $id);
        return $this->questionRepository->show($id);
    }
}
