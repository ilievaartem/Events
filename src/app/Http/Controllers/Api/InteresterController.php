<?php

namespace App\Http\Controllers\Api;

use App\Constants\Request\InteresterRequestConstants;
use App\Services\AuthWrapperService;
use App\Services\InteresterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class InteresterController extends Controller
{
    public function __construct(
        private InteresterService $interesterService,
        private readonly AuthWrapperService $authWrapperService
    ) {
    }
    public function EventInteresters(string $eventId): JsonResponse
    {
        return response()->json($this->interesterService->EventInteresters($eventId));
    }
    public function show(string $id): JsonResponse
    {
        return response()->json($this->interesterService->show($id));
    }
    public function interesterCount(string $eventId): JsonResponse
    {
        return response()->json(['Interesters' => $this->interesterService->interesterCount($eventId)]);
    }
    public function changeInteresterStatus(Request $request, string $eventId): JsonResponse
    {
        return response()->json(
            $this->interesterService->changeInteresterStatus(
                $eventId,
                $this->authWrapperService->getAuthIdentifier()
            )
        );
    }
}
