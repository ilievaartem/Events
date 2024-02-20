<?php

namespace App\Http\Controllers;

use App\Constants\Request\ApplierRequestConstants;
use App\Services\ApplierService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class ApplierController extends Controller
{

    public function __construct(private ApplierService $applierService)
    {
        $this->applierService = $applierService;
    }
    public function index(Request $request): JsonResponse
    {
        return response()->json($this->applierService->index());
    }
    public function show(string $id): JsonResponse
    {
        return response()->json($this->applierService->show($id));
    }
    public function create(Request $request): JsonResponse
    {
        $eventId = $request->input(ApplierRequestConstants::EVENT_ID);
        $authorId = $request->input(ApplierRequestConstants::AUTHOR_ID);

        return response()->json($this->applierService->create($eventId, $authorId));
    }
    public function update(Request $request, string $id): JsonResponse
    {
        return response()->json($this->applierService->update($request->all(), $id));
    }
    public function delete(string $id): JsonResponse
    {
        return response()->json($this->applierService->delete($id));

    }
}
