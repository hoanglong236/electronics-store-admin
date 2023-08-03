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
        $today = '2023/08/02';
        $data = [];

        $data['pageTitle'] = 'Dashboard';
        $data['dashboardData'] = $this->dashboardService->getDashboardData($today);

        return view('pages.dashboard.dashboard-page', ['data' => $data]);
    }
}
