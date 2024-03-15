<?php

namespace App\Http\Controllers;

use App\Constants\Request\QuestionRequestConstants;
use App\Factory\Question\CreateQuestionDTOFactory;
use App\Factory\Question\ResponseToQuestionDTOFactory;
use App\Factory\Question\UpdateQuestionDTOFactory;
use App\Http\Requests\Questions\CreateQuestionRequest;
use App\Http\Requests\Questions\QuestionsCreateRequest;
use App\Http\Requests\Questions\QuestionsUpdateRequest;
use App\Http\Requests\Questions\ResponseToQuestionRequest;
use App\Services\AuthWrapperService;
use App\Services\QuestionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class QuestionController extends Controller
{
    public function __construct(
        private QuestionService $questionService,
        private readonly AuthWrapperService $authWrapperService
    ) {
    }
    public function index(Request $request): JsonResponse
    {
        return response()->json($this->questionService->index());
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
    public function responseToQuestion(
        ResponseToQuestionRequest $request,
        ResponseToQuestionDTOFactory $responseToQuestionDTOFactory,

        string $eventId
    ): JsonResponse {
        return response()->json(
            $this->questionService->responseToQuestion(
                $responseToQuestionDTOFactory->make($request, $eventId, $$this->authWrapperService->getAuthIdentifier())
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
