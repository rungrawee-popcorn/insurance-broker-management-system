<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Services\Dashboard\DashboardService;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * Dashboard service instance.
     */
    public function __construct(
        private readonly DashboardService $dashboardService,
    ) {
    }

    /**
     * Display the dashboard.
     */
    public function index(): View
    {
        $dashboard = $this->dashboardService->getDashboardData();

        return view('dashboard', [
            'dashboard' => $dashboard,
        ]);
    }
}