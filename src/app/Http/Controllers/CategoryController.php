<?php

namespace App\Http\Controllers;

use App\Constants\Request\CategoryRequestConstants;
use App\Http\Requests\Categories\CategoryCreateRequest;
use App\Http\Requests\Categories\CategoryUpdateRequest;
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
        return response()->json(
            $this->categoryService->create(
                $request->input(CategoryRequestConstants::NAME),
                $request->input(CategoryRequestConstants::PARENT_ID)
            )
        );
    }
    public function update(CategoryUpdateRequest $request, int $id): JsonResponse
    {
        return response()->json($this->categoryService->update($request->input(CategoryRequestConstants::NAME), $id));
    }
    public function delete(int $id): JsonResponse
    {
        return response()->json(['success' => $this->categoryService->delete($id)]);

    }
    public function show(int $id): JsonResponse
    {
        return response()->json($this->categoryService->show($id));
    }
    public function getCategoryChild(int $id): JsonResponse
    {
        return response()->json($this->categoryService->getCategoryChild($id));
    }
}
