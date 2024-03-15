<?php

namespace App\Http\Controllers;

use App\Constants\DB\PlaceDBConstants;
use App\Http\Requests\Places\PlaceCreateRequest;
use App\Http\Requests\Places\PlaceUpdateRequest;
use App\Services\PlaceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PlaceController extends Controller
{
    public function __construct(private PlaceService $placeService)
    {
    }
    public function CommunityPlaces(int $communityId): JsonResponse
    {
        return response()->json($this->placeService->CommunityPlaces($communityId));
    }
    public function show(int $id): JsonResponse
    {
        return response()->json($this->placeService->show($id));
    }
    public function create(PlaceCreateRequest $request, int $communityId): JsonResponse
    {
        return response()->json(
            $this->placeService->create(
                $request->input(PlaceDBConstants::NAME),
                $request->input(PlaceDBConstants::TYPE),
                $communityId
            )
        );
    }
    public function update(PlaceUpdateRequest $request, int $communityId, int $id): JsonResponse
    {
        return response()->json(
            $this->placeService->update(
                $id,
                $request->input(PlaceDBConstants::NAME),
                $request->input(PlaceDBConstants::TYPE),
                $communityId
            )
        );
    }
    public function delete(int $id): JsonResponse
    {
        return response()->json(['success' => $this->placeService->delete($id)]);
    }
}
