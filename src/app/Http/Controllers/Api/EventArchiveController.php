<?php

namespace App\Http\Controllers\Api;

use App\Constants\Request\EventRequestConstants;
use App\DTO\Event\CreateEventDTO;
use App\Http\Requests\Events\EventCreateRequest;
use App\Services\AuthWrapperService;
use App\Services\EventArchiveService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventArchiveController extends Controller
{
    public function __construct(
        private EventArchiveService $eventArchiveService,
        private readonly AuthWrapperService $authWrapperService
    ) {
    }

    public function archive(string $eventId): JsonResponse
    {
        return response()->json($this->eventArchiveService->archive($eventId));
    }
    public function showUserEventArchives(string $userId): JsonResponse
    {
        return response()->json($this->eventArchiveService->showUserEventArchives($userId));
    }
    public function unarchive(string $id): JsonResponse
    {
        return response()->json($this->eventArchiveService->unarchive($id));
    }

    public function delete(string $id): JsonResponse
    {
        return response()->json($this->eventArchiveService->delete($id));

    }
    public function show(string $id): JsonResponse
    {
        return response()->json($this->eventArchiveService->show($id));

    }
}
