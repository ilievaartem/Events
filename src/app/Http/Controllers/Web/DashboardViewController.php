<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\View\View;

class DashboardViewController extends Controller
{
    public function __construct(
        private readonly DashboardService $dashboardService,)
    {
    }

    public function index(): View
    {
        $content = $this->dashboardService->index();
        $complaintsStatistics = $this->dashboardService->getComplaintsStatistics();

        return view('dashboard.index', [
            'content' => $content,
            'complaintsStatistics' => $complaintsStatistics,
        ]);
    }
}
