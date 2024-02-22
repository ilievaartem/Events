<?php

namespace App\Http\Controllers;

use App\Services\TagService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function __construct(private TagService $tagService)
    {
    }
    public function index(): JsonResponse
    {
        return response()->json($this->tagService->index());
    }

    public function create(Request $request): JsonResponse
    {

        return response()->json($this->tagService->create($request->all()));
    }
    public function update(Request $request, int $id): JsonResponse
    {
        return response()->json($this->tagService->update($request->all(), $id));
    }
    public function delete(int $id): JsonResponse
    {
        return response()->json(['success' => $this->tagService->delete($id)]);


    }
    public function show(int $id): JsonResponse
    {
        return response()->json($this->tagService->show($id));
    }
}
