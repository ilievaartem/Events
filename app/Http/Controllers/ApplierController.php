<?php

namespace App\Http\Controllers;

use App\Constants\Request\ApplierRequestConstants;
use App\Services\ApplierService;
use App\Services\AuthWrapperService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Ramsey\Uuid\Uuid;

class ApplierController extends Controller
{

    public function __construct(
        private ApplierService $applierService,
        private readonly AuthWrapperService $authWrapperService
    ) {
    }
    public function index(Request $request): JsonResponse
    {
        return response()->json($this->applierService->index());
    }
    public function show(string $id): JsonResponse
    {
        return response()->json($this->applierService->show($id));
    }
    public function update(Request $request, string $id): JsonResponse
    {
        $authorId = $this->authWrapperService->getAuthIdentifier();
        return response()->json(['success' => $this->applierService->update($id, $authorId)]);
    }

}
