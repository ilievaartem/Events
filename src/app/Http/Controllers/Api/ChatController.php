<?php

namespace App\Http\Controllers\Api;

use App\Services\AuthWrapperService;
use App\Services\ChatService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function __construct(
        private ChatService $chatService,
        private readonly AuthWrapperService $authWrapperService
    ) {

    }
    public function show(string $id): JsonResponse
    {
        return response()->json($this->chatService->show($id));
    }
    public function getChatWithAllMessages(string $id): JsonResponse
    {
        return response()->json($this->chatService->getChatWithAllMessages($id));
    }
    public function getAllAuthorChat(): JsonResponse
    {
        return response()->json($this->chatService->getAllAuthorChat($this->authWrapperService->getAuthIdentifier()));
    }
    public function getAllMemberChat(): JsonResponse
    {
        return response()->json($this->chatService->getAllMemberChat($this->authWrapperService->getAuthIdentifier()));
    }
    public function delete(string $id): JsonResponse
    {
        return response()->json(['success' => $this->chatService->delete($id)]);
    }
}
