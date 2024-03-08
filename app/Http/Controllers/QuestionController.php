<?php

namespace App\Http\Controllers;

use App\Constants\Request\QuestionRequestConstants;
use App\Http\Requests\Questions\QuestionsCreateRequest;
use App\Http\Requests\Questions\QuestionsUpdateRequest;
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
    public function show(string $id): JsonResponse
    {
        return response()->json($this->questionService->show($id));
    }
    public function create(QuestionsCreateRequest $request, string $eventId): JsonResponse
    {
        $parentId = $request->input(QuestionRequestConstants::PARENT_ID);
        $authorId = $this->authWrapperService->getAuthIdentifier();
        $content = $request->input(QuestionRequestConstants::CONTENT);
        return response()->json($this->questionService->create($eventId, $authorId, $parentId, $content));
    }
    public function update(QuestionsUpdateRequest $request, string $id): JsonResponse
    {
        return response()->json($this->questionService->update($request->all(), $id));
    }
    public function delete(string $id): JsonResponse
    {
        return response()->json(['success' => $this->questionService->delete($id)]);
    }
}
