<?php

namespace App\Http\Controllers\Web;

use App\Exceptions\ConflictException;
use App\Exceptions\NotFoundException;
use App\Factory\User\CreateUserDTOFactory;
use App\Factory\User\UpdateUserDTOFactory;
use App\Http\Controllers\Api\Controller;
use App\Http\Requests\Test;
use App\Services\System\DataFormattersService;
use App\Services\UserService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class UsersViewController extends Controller
{
    public function __construct(private readonly UserService           $userService,
                                private readonly DataFormattersService $dataFormattersService)
    {
    }

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $filter = [
            'search' => $request->input('search'),
            'role' => $request->input('role'),
            'is_banned' => $request->input('is_banned'),
            'field' => $request->input('field'),
            'direction' => $request->input('direction'),
        ];
        $content = $this->userService->index($filter);

        return view('users.index', $this->dataFormattersService->formatViewResponse($content, $filter));
    }

    /**
     * @return View
     */
    public function showCreate(): View
    {
        return view('users.create');
    }

    /**
     * @param string $id
     * @return View
     */
    public function viewUser(string $id): View
    {
        $content = $this->userService->show($id);

        return view('users.show', [
            'content' => $content,
            'viewOnly' => true,
        ]);
    }

    /**
     * @param string $id
     * @return View
     */
    public function show(string $id): View
    {
        $content = $this->userService->show($id);

        return view('users.show', [
            'content' => $content,
            'viewOnly' => false,
        ]);
    }

    /**
     * @param Request $request
     * @param string $id
     * @param UpdateUserDTOFactory $updateUserDTOFactory
     * @return RedirectResponse
     * @throws ConflictException
     * @throws NotFoundException
     */
    public function update(Request $request, string $id, UpdateUserDTOFactory $updateUserDTOFactory): RedirectResponse
    {
        $this->userService->update($updateUserDTOFactory->make($request, $id));

        return redirect()->back();
    }

    /**
     * @param Test $request
     * @param CreateUserDTOFactory $createUserDTOFactory
     * @return RedirectResponse
     * @throws ConflictException
     */
    public function create(Test $request, CreateUserDTOFactory $createUserDTOFactory): RedirectResponse
    {
        $this->userService->create($createUserDTOFactory->make($request));

        return redirect()->route('users.index');
    }

    /**
     * @param string $id
     * @return RedirectResponse
     */
    public function delete(string $id): RedirectResponse
    {
        $this->userService->delete($id);

        return redirect()->route('users.index');
    }

    /**
     * @return View
     */
    public function test(): View
    {
        return view('test');
    }
}
