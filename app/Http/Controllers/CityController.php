<?php

namespace App\Http\Controllers;

use App\Constants\Request\CityRequestConstants;
use App\Services\CityService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function __construct(private CityService $cityService)
    {
        $this->cityService = $cityService;
    }
    public function index(Request $request): JsonResponse
    {
        return response()->json($this->cityService->index());
    }
    public function show(int $id): JsonResponse
    {
        return response()->json($this->cityService->show($id));
    }
    public function create(Request $request, string $countryId): JsonResponse
    {
        $name = $request->input(CityRequestConstants::NAME);
        return response()->json($this->cityService->create($countryId, $name));
    }
    public function update(Request $request, int $id): JsonResponse
    {
        return response()->json($this->cityService->update($request->all(), $id));
    }
    public function delete(int $id): JsonResponse
    {
        return response()->json(['success' => $this->cityService->delete($id)]);
    }
}
