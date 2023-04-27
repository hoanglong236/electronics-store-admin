<?php

namespace App\Http\Controllers;

use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    private $dashboardService;

    public function __construct()
    {
        $this->dashboardService = new DashboardService();
    }

    public function index()
    {
        $firstDayOfMonth = Carbon::now()->firstOfMonth();
        $currentDay = Carbon::now();
        $orderStatisticData = $this->dashboardService->getOrderStatisticData($firstDayOfMonth, $currentDay);

        $data = [
            'pageTitle' => 'Dashboard',
            'orderStatisticData' => $orderStatisticData,
        ];
        return view('pages.dashboard.dashboard-page', ['data' => $data]);
    }
}
