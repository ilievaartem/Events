<?php

namespace App\Http\Controllers\Web;

use App\Factory\Complaint\FilterComplaintDTOFactory;
use App\Factory\Dashboard\DashboardDTOFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\Complaints\ComplaintFilterRequest;
use App\Services\DashboardService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardViewController extends Controller
{
    public function __construct(
        private readonly DashboardService $dashboardService,)
    {
    }

    /**
     * @return View
     */
    public function index(): View
    {
        $content = $this->dashboardService->index();
        $complaintsStatistics = $this->dashboardService->getComplaintsStatistics();

        return view('dashboard.index', [
            'content' => $content,
            'complaintsStatistics' => $complaintsStatistics,
        ]);
    }

    /**
     * @param ComplaintFilterRequest $request
     * @param FilterComplaintDTOFactory $filterComplaintDTOFactory
     * @return JsonResponse
     */
    public function filter(ComplaintFilterRequest $request, FilterComplaintDTOFactory $filterComplaintDTOFactory): JsonResponse
    {
        return response()->json($this->dashboardService->filter($filterComplaintDTOFactory->make($request)));
    }

    /**
     * @param Request $request
     * @param DashboardDTOFactory $dashboardDTOFactory
     * @return JsonResponse
     */
    public function count(Request $request, DashboardDTOFactory $dashboardDTOFactory): JsonResponse
    {
        return response()->json($this->dashboardService->getCountsByYearAndMonths($dashboardDTOFactory->make($request)));
    }
}
