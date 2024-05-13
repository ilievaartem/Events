<?php

namespace App\Http\Controllers\Api;

use App\Factory\Question\AnswerQuestionDTOFactory;
use App\Factory\Question\CreateQuestionDTOFactory;
use App\Factory\Question\UpdateQuestionDTOFactory;
use App\Http\Requests\Questions\AnswerQuestionRequest;
use App\Http\Requests\Questions\CreateQuestionRequest;
use App\Http\Requests\Questions\QuestionsUpdateRequest;
use App\Services\AuthWrapperService;
use App\Services\QuestionService;
use Illuminate\Http\JsonResponse;

class QuestionController extends Controller
{
    public function __construct(
        private QuestionService $questionService,
        private readonly AuthWrapperService $authWrapperService
    ) {
    }

    public function getQuestionsByAuthorId(string $authorId): JsonResponse
    {
        return response()->json($this->questionService->getQuestionsByAuthorId($authorId));
    }
    public function getEventQuestions(string $eventId): JsonResponse
    {
        return response()->json($this->questionService->getEventQuestions($eventId));
    }
    public function show(string $id): JsonResponse
    {
        return response()->json($this->questionService->show($id));
    }
    public function createQuestion(
        CreateQuestionRequest $request,
        CreateQuestionDTOFactory $createQuestionDTOFactory,
        string $eventId
    ): JsonResponse {
        return response()->json(
            $this->questionService->createQuestion(
                $createQuestionDTOFactory->make($request, $eventId, $this->authWrapperService->getAuthIdentifier())
            )
        );
    }
    public function answerToQuestion(
        AnswerQuestionRequest $request,
        AnswerQuestionDTOFactory $answerQuestionDTOFactory,

        string $eventId
    ): JsonResponse {
        return response()->json(
            $this->questionService->answerToQuestion(
                $answerQuestionDTOFactory->make($request, $eventId, $this->authWrapperService->getAuthIdentifier())
            )
        );
    }
    public function update(
        QuestionsUpdateRequest $request,
        UpdateQuestionDTOFactory $updateQuestionDTOFactory,
        string $questionId
    ): JsonResponse {
        return response()->json(
            $this->questionService->update(
                $updateQuestionDTOFactory->make($request, $questionId)
            )
        );
    }

}
