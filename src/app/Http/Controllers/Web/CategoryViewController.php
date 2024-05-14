<?php

namespace App\Http\Controllers\Web;

use App\Constants\Request\CategoryRequestConstants;
use App\Exceptions\ConflictException;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Api\Controller;
use App\Models\Category;
use App\Services\CategoryService;
use App\Services\System\DataFormattersService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryViewController extends Controller
{

    public function __construct(private readonly CategoryService       $categoryService,
                                private readonly DataFormattersService $dataFormattersService
    )
    {

    }

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $filter = [
            'name' => $request->query('name'),
        ];

        $content = $this->categoryService->index($filter);

        return view('categories.index', $this->dataFormattersService->formatViewResponse($content, $filter));
    }

    /**
     * @return View
     */
    public function showCreate(): View
    {
        $allCategories = $this->categoryService->getTable();

        return view('categories.create', ['allCategories' => $allCategories]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function viewCategory(int $id): View
    {
        $content = $this->categoryService->show($id);
        $allCategories = $this->categoryService->getTable();

        return view('categories.show', [
            'content' => $content,
            'viewOnly' => true,
            'allCategories' => $allCategories,
        ]);
    }

    /**
     * @param int $id
     * @return View
     */
    public function show(int $id): View
    {
        $content = $this->categoryService->show($id);
        $allCategories = $this->categoryService->getTable();

        return view('categories.show', [
            'content' => $content,
            'viewOnly' => false,
            'allCategories' => $allCategories,
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws \App\Exceptions\ConflictException
     */
    public function create(Request $request): RedirectResponse
    {
        $this->categoryService->create(
            $request->input(CategoryRequestConstants::NAME),
            $request->input(CategoryRequestConstants::PARENT_ID)
        );

        return redirect()->route('categories.index');
    }

    /**
     * @param int $id
     * @param Request $request
     * @return RedirectResponse
     * @throws ConflictException
     * @throws NotFoundException
     */
    public function update(int $id, Request $request): RedirectResponse
    {
        $this->categoryService->update(
            $request->input(CategoryRequestConstants::NAME),
            $request->input(CategoryRequestConstants::PARENT_ID),$id
        );

        return redirect()->back();
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function delete(int $id): RedirectResponse
    {
        $this->categoryService->delete($id);

        return redirect()->route('categories.index');
    }
}
