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

    public function getCommentsByAuthorId(string $authorId): JsonResponse
    {
        return response()->json($this->commentService->getCommentsByAuthorId($authorId));
    }
    public function getEventComments(string $eventId): JsonResponse
    {
        return response()->json($this->commentService->getEventComments($eventId));
    }
    public function create(CommentsCreateRequest $request, string $eventId): JsonResponse
    {
        $authorId = $this->authWrapperService->getAuthIdentifier();
        $content = $request->input(CommentRequestConstants::CONTENT);
        return response()->json($this->commentService->create($eventId, $authorId, $content));
    }
    public function update(CommentsUpdateRequest $request, string $id): JsonResponse
    {
        return response()->json($this->commentService->update($request->input(CommentRequestConstants::CONTENT), $id));
    }
    public function delete(string $id): JsonResponse
    {
        return response()->json($this->commentService->delete($id));

    }
    public function show(string $id): JsonResponse
    {
        return response()->json(['success' => $this->commentService->delete($id)]);

    }
}
