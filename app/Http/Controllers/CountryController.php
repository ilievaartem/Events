<?php

namespace App\Http\Controllers;

use App\Services\CountryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __construct(private CountryService $countryService)
    {
        $this->countryService = $countryService;
    }
    public function index(Request $request): JsonResponse
    {
        return response()->json($this->countryService->index());
    }
    public function show(int $id): JsonResponse
    {
        return response()->json($this->countryService->show($id));
    }
    public function create(Request $request): JsonResponse
    {

        return response()->json($this->countryService->create($request->all()));
    }
    public function update(Request $request, int $id): JsonResponse
    {
        return response()->json($this->countryService->update($request->all(), $id));
    }
    public function delete(int $id): JsonResponse
    {
        return response()->json(['success' => $this->countryService->delete($id)]);


    }
}
