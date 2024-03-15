<?php

namespace App\Http\Controllers;

use App\Constants\DB\CommunityDBConstants;
use App\Http\Requests\Communities\CommunityCreateRequest;
use App\Http\Requests\Communities\CommunityUpdateRequest;
use App\Services\CommunityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CommunityController extends Controller
{
    public function __construct(private CommunityService $communityService)
    {
    }
    public function RegionCommunities(int $regionId): JsonResponse
    {
        return response()->json($this->communityService->RegionCommunities($regionId));
    }
    public function show(int $id): JsonResponse
    {
        return response()->json($this->communityService->show($id));
    }
    public function create(CommunityCreateRequest $request, int $regionId): JsonResponse
    {
        return response()->json($this->communityService->create($request->input(CommunityDBConstants::NAME), $regionId));
    }
    public function update(CommunityUpdateRequest $request, int $regionId, int $id): JsonResponse
    {
        return response()->json($this->communityService->update($id, $request->input(CommunityDBConstants::NAME), $regionId));
    }
    public function delete(int $id): JsonResponse
    {
        return response()->json(['success' => $this->communityService->delete($id)]);
    }
}
