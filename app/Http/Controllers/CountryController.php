<?php

namespace App\Http\Controllers;

use App\Constants\Request\CountryRequestConstants;
use App\Http\Requests\Countries\CountryCreateRequest;
use App\Http\Requests\Countries\CountryUpdateRequest;
use App\Services\CountryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    public function __construct(private CountryService $countryService)
    {
    }
    public function index(): JsonResponse
    {
        return response()->json($this->countryService->index());
    }
    public function show(int $id): JsonResponse
    {
        return response()->json($this->countryService->show($id));
    }
    public function create(CountryCreateRequest $request): JsonResponse
    {
        return response()->json($this->countryService->create($request->insert(CountryRequestConstants::NAME)));
    }
    public function update(CountryUpdateRequest $request, int $id): JsonResponse
    {
        return response()->json($this->countryService->update($request->insert(CountryRequestConstants::NAME), $id));
    }
    public function delete(int $id): JsonResponse
    {
        return response()->json(['success' => $this->countryService->delete($id)]);
    }
}
