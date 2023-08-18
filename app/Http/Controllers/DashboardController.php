<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;

class DashboardController extends Controller
{
    private $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $today = date('Y-m-d');

        $data = [];
        $data['dashboardData'] = $this->dashboardService->getDashboardData($today);
        $data['pageTitle'] = 'Dashboard';

        return view('pages.dashboard.dashboard-page', ['data' => $data]);
    }
}
