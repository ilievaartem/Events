<?php

namespace App\Http\Controllers;

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
    public function create(Request $request): JsonResponse
    {

        return response()->json($this->cityService->create($request->all()));
    }
    public function update(Request $request, int $id): JsonResponse
    {
        return response()->json($this->cityService->update($request->all(), $id));
    }
    public function delete(int $id): JsonResponse
    {
        return response()->json($this->cityService->delete($id));

    }
}
