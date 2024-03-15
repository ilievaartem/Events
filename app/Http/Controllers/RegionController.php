<?php

namespace App\Http\Controllers;

use App\Constants\DB\RegionDBConstants;
use App\Http\Requests\Regions\RegionCreateRequest;
use App\Http\Requests\Regions\RegionUpdateRequest;
use App\Services\RegionService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class RegionController extends Controller
{
    public function __construct(private RegionService $regionService)
    {
    }
    public function CountryRegions(int $countryId): JsonResponse
    {
        return response()->json($this->regionService->CountryRegions($countryId));
    }
    public function show(int $id): JsonResponse
    {
        return response()->json($this->regionService->show($id));
    }
    public function create(RegionCreateRequest $request, int $countryId): JsonResponse
    {
        return response()->json($this->regionService->create($request->input(RegionDBConstants::NAME), $countryId));
    }
    public function update(RegionUpdateRequest $request, int $countryId, int $id): JsonResponse
    {
        return response()->json($this->regionService->update($id, $request->input(RegionDBConstants::NAME), $countryId));
    }
    public function delete(int $id): JsonResponse
    {
        return response()->json(['success' => $this->regionService->delete($id)]);
    }
}
