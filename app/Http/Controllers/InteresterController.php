<?php

namespace App\Http\Controllers;

use App\Constants\Request\InteresterRequestConstants;
use App\Services\AuthWrapperService;
use App\Services\InteresterService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class InteresterController extends Controller
{
    public function __construct(
        private InteresterService $interesterService,
        private readonly AuthWrapperService $authWrapperService
    ) {
    }
    public function index(Request $request): JsonResponse
    {
        return response()->json($this->interesterService->index());
    }
    public function show(string $id): JsonResponse
    {
        return response()->json($this->interesterService->show($id));
    }
    public function update(Request $request, string $id): JsonResponse
    {
        $authorId = $this->authWrapperService->getAuthIdentifier();
        return response()->json($this->interesterService->update($id, $authorId));
    }
}
