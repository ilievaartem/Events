<?php

namespace App\Http\Controllers\Api;

use App\Constants\DB\PlaceDBConstants;
use App\DTO\Place\CreatePlaceDTO;
use App\DTO\Place\UpdatePlaceDTO;
use App\Exceptions\NotFoundException;
use App\Http\Requests\Places\PlaceCreateRequest;
use App\Http\Requests\Places\PlaceUpdateRequest;
use App\Services\PlaceService;
use Illuminate\Http\JsonResponse;

class PlaceController extends Controller
{
    public function __construct(private readonly PlaceService $placeService)
    {
    }

    /**
     * @throws NotFoundException
     */
    public function CommunityPlaces(int $communityId): JsonResponse
    {
        return response()->json($this->placeService->communityPlaces($communityId));
    }

    /**
     * @param int $id
     * @return JsonResponse
     * @throws NotFoundException
     */
    public function show(int $id): JsonResponse
    {
        return response()->json($this->placeService->show($id));
    }

    public function create(PlaceCreateRequest $request, int $communityId): JsonResponse
    {
        $createPlaceDTO = new CreatePlaceDTO(
            $request->input(PlaceDBConstants::NAME),
            $request->input(PlaceDBConstants::TYPE),
            $communityId
        );
        return response()->json($this->placeService->create($createPlaceDTO));
    }

    /**
     * @param PlaceUpdateRequest $request
     * @param int $communityId
     * @param int $id
     * @return JsonResponse
     * @throws NotFoundException
     * @throws \App\Exceptions\ConflictException
     */
    public function update(PlaceUpdateRequest $request, int $communityId, int $id): JsonResponse
    {
        $updatePlaceDTO = new UpdatePlaceDTO(
            $id,
            $request->input(PlaceDBConstants::NAME), $request->input(PlaceDBConstants::TYPE),
            $communityId
        );
        return response()->json($this->placeService->update($updatePlaceDTO));
    }

    public function delete(int $id): JsonResponse
    {
        return response()->json(['success' => $this->placeService->delete($id)]);
    }
}
