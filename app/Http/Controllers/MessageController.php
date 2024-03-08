<?php

namespace App\Http\Controllers;

use App\Constants\Request\MessageRequestConstants;
use App\Http\Requests\Messages\MessageCreateRequest;
use App\Http\Requests\Messages\MessageUpdateRequest;
use App\Services\AuthWrapperService;
use App\Services\MessageService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function __construct(
        private MessageService $messageService,
        private readonly AuthWrapperService $authWrapperService
    ) {
    }
    public function index(Request $request): JsonResponse
    {
        return response()->json($this->messageService->index());
    }
    public function show(string $id): JsonResponse
    {
        return response()->json($this->messageService->show($id));
    }
    public function create(MessageCreateRequest $request, string $eventId): JsonResponse
    {
        $receiverId = $request->input(MessageRequestConstants::RECEIVER_ID);
        $responderId = $this->authWrapperService->getAuthIdentifier();
        $text = $request->input(MessageRequestConstants::TEXT);
        return response()->json($this->messageService->create($eventId, $receiverId, $responderId, $text));
    }
    public function update(MessageUpdateRequest $request, string $id): JsonResponse
    {
        return response()->json($this->messageService->update($request->input(MessageRequestConstants::TEXT), $id));
    }
    public function delete(string $id): JsonResponse
    {
        return response()->json(['success' => $this->messageService->delete($id)]);
    }
}
