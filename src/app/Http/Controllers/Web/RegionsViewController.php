<?php

namespace App\Http\Controllers\Web;

use App\Constants\DB\RegionDBConstants;
use App\Exceptions\ConflictException;
use App\Exceptions\NotFoundException;
use App\Http\Controllers\Api\Controller;
use App\Services\RegionService;
use App\Services\System\DataFormattersService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RegionsViewController extends Controller
{

    public function __construct(private readonly RegionService         $regionService,
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
            'search' => $request->input('search'),
            'field' => $request->input('field'),
            'direction' => $request->input('direction'),
        ];

        $content = $this->regionService->index($filter);

        return view('regions.index', $this->dataFormattersService->formatViewResponse($content, $filter));
    }

    /**
     * @return View
     */
    public function showCreate(): View
    {
        $countries = $this->regionService->getTable();

        return view('regions.create', ['countries' => $countries]);
    }

    /**
     * @param string $id
     * @return View
     */
    public function viewRegion(string $id): View
    {
        $content = $this->regionService->show($id);
        $countries = $this->regionService->getTable();

        return view('regions.show', [
            'content' => $content,
            'viewOnly' => true,
            'countries' => $countries,]);
    }

    /**
     * @param $id
     * @return View
     */
    public function show($id): View
    {
        $content = $this->regionService->show($id);
        $countries = $this->regionService->getTable();

        return view('regions.show', [
            'content' => $content,
            'viewOnly' => false,
            'countries' => $countries,]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     * @throws ConflictException
     * @throws NotFoundException
     */
    public function create(Request $request): RedirectResponse
    {
        $this->regionService->create(
            $request->input(RegionDBConstants::NAME),
            $request->input(RegionDBConstants::COUNTRY_ID)
        );
        return redirect()->route('regions.index');
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
        $this->regionService->update($id,
            $request->input(RegionDBConstants::NAME),
            $request->input(RegionDBConstants::COUNTRY_ID)
        );
        return redirect()->back();
    }

    /**
     * @param string $id
     * @return RedirectResponse
     */
    public function delete(string $id): RedirectResponse
    {
        $this->regionService->delete($id);

        return redirect()->route('regions.index');
    }
}
