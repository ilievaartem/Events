<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comments\CommentsCreateRequest;
use App\Http\Requests\Comments\CommentsUpdateRequest;
use App\Services\CommentService;
use Illuminate\Http\Request;
use App\Constants\Request\CommentRequestConstants;
use App\Services\AuthWrapperService;
use Illuminate\Http\JsonResponse;
use Ramsey\Uuid\Uuid;

class CommentController extends Controller
{

    public function __construct(
        private CommentService $commentService,
        private readonly AuthWrapperService $authWrapperService
    ) {
    }
    public function index(Request $request): JsonResponse
    {
        return response()->json($this->commentService->index());
    }

    public function create(Request $request): JsonResponse
    {
        $eventId = $request->input(CommentRequestConstants::EVENT_ID);
        $authorId = $this->authWrapperService->getAuthIdentifier();
        $content = $request->input(CommentRequestConstants::CONTENT);
        return response()->json($this->commentService->create($eventId, $authorId, $content));
    }
    public function update(Request $request, int $id): JsonResponse
    {
        return response()->json($this->commentService->update($request->all(), $id));
    }
    public function delete(int $id): JsonResponse
    {
        return response()->json($this->commentService->delete($id));

    }
    public function show(string $id): JsonResponse
    {
        return response()->json(['success' => $this->commentService->delete($id)]);

    }
}
