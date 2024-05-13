<?php

namespace App\Http\Controllers\Api;

use App\Constants\Request\TagRequestConstants;
use App\Http\Requests\Tags\TagsCreateRequest;
use App\Http\Requests\Tags\TagsUpdateRequest;
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

    public function create(TagsCreateRequest $request): JsonResponse
    {
        return response()->json($this->tagService->create($request->input(TagRequestConstants::NAME)));
    }
    public function update(TagsUpdateRequest $request, int $id): JsonResponse
    {
        return response()->json($this->tagService->update($request->input(TagRequestConstants::NAME), $id));
    }
    public function delete(int $id): JsonResponse
    {
        return response()->json(['success' => $this->tagService->delete($id)]);


    }
    // public function show(int $id): JsonResponse
    // {
    //     return response()->json($this->tagService->show($id));
    // }
}
