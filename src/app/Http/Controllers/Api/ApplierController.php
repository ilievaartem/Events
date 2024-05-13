<?php

namespace App\Http\Controllers\Api;

use App\Constants\Request\ApplierRequestConstants;
use App\Services\ApplierService;
use App\Services\AuthWrapperService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class ApplierController extends Controller
{

    public function __construct(
        private ApplierService $applierService,
        private readonly AuthWrapperService $authWrapperService
    ) {
    }
    public function EventAppliers(string $eventId): JsonResponse
    {
        return response()->json($this->applierService->EventAppliers($eventId));
    }
    public function applierCount(string $eventId): JsonResponse
    {
        return response()->json(['Appliers' => $this->applierService->applierCount($eventId)]);
    }
    public function show(string $id): JsonResponse
    {
        return response()->json($this->applierService->show($id));
    }
    public function changeApplierStatus(string $eventId): JsonResponse
    {
        return response()->json([
            'success' => $this->applierService->changeApplierStatus(
                $eventId,
                $this->authWrapperService->getAuthIdentifier()
            )
        ]);
    }

}
