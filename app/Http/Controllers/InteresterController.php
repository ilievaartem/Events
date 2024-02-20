<?php

namespace App\Http\Controllers;

use App\Constants\Request\InteresterRequestConstants;
use App\Services\InteresterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class InteresterController extends Controller
{
    public function __construct(private InteresterService $interesterService)
    {
        $this->interesterService = $interesterService;
    }
    public function index(Request $request): JsonResponse
    {
        return response()->json($this->interesterService->index());
    }
    public function show(string $id): JsonResponse
    {
        return response()->json($this->interesterService->show($id));
    }
    public function create(Request $request): JsonResponse
    {
        $eventId = $request->input(InteresterRequestConstants::EVENT_ID);
        $authorId = $request->input(InteresterRequestConstants::AUTHOR_ID);
        return response()->json($this->interesterService->create($eventId, $authorId));
    }
    public function update(Request $request, string $id): JsonResponse
    {
        return response()->json($this->interesterService->update($request->all(), $id));
    }
    public function delete(string $id): JsonResponse
    {
        return response()->json($this->interesterService->delete($id));

    }
}
