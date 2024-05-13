<?php

namespace App\Http\Controllers\Api;

use App\Constants\Request\MessageRequestConstants;
use App\Factory\Message\CreateMessageDTOFactory;
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

    public function show(string $id): JsonResponse
    {
        return response()->json($this->messageService->show($id));
    }
    public function create(
        MessageCreateRequest $request,
        CreateMessageDTOFactory $createMessageDTOFactory,
        string $eventId
    ): JsonResponse {
        return response()->json(
            $this->messageService->create(
                $createMessageDTOFactory->make($request, $eventId, $this->authWrapperService->getAuthIdentifier())
            )
        );
    }
    public function update(MessageUpdateRequest $request, string $id): JsonResponse
    {
        return response()->json($this->messageService->update($request->input(MessageRequestConstants::TEXT), $id));
    }

}
