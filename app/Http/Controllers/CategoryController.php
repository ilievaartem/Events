<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\CategoryCreateRequest;
use App\Http\Requests\Category\CategoryUpdateRequest;
use App\Services\CategoryService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    public function __construct(private CategoryService $categoryService)
    {
    }
    public function index(): JsonResponse
    {
        return response()->json($this->categoryService->index());
    }

    public function create(CategoryCreateRequest $request): JsonResponse
    {

        return response()->json($this->categoryService->create($request->all()));
    }
    public function update(CategoryUpdateRequest $request, int $id): JsonResponse
    {
        return response()->json($this->categoryService->update($request->all(), $id));
    }
    public function delete(int $id): JsonResponse
    {
        return response()->json($this->categoryService->delete($id));

    }
    public function show(int $id): JsonResponse
    {
        return response()->json($this->categoryService->show($id));
    }
}
