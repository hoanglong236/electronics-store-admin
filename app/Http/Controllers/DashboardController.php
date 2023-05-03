<?php

namespace App\Http\Controllers;

use App\Http\Requests\DashboardExportExcelRequest;
use App\Http\Requests\DashboardSearchRequest;
use App\Services\DashboardExportExcelService;
use App\Services\DashboardService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    private $dashboardService;
    private $dashboardExportExcelService;

    public function __construct()
    {
        $this->dashboardService = new DashboardService();
        $this->dashboardExportExcelService = new DashboardExportExcelService();
    }

    private function getCommonDataForDashboardPage($fromDate, $toDate)
    {
        $newCustomerCount = $this->dashboardService->getNewCustomerCount($fromDate, $toDate);
        $placedOrderCount = $this->dashboardService->getPlacedOrderCount($fromDate, $toDate);
        $solidItemCount = $this->dashboardService->getSolidItemCount($fromDate, $toDate);
        $orderStatisticData = $this->dashboardService->getOrderStatisticData($fromDate, $toDate);

        return [
            'pageTitle' => 'Dashboard',
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'newCustomerCount' => $newCustomerCount,
            'placedOrderCount' => $placedOrderCount,
            'solidItemCount' => $solidItemCount,
            'orderStatisticData' => $orderStatisticData,
        ];
    }

    public function index()
    {
        $firstDayOfMonth = Carbon::now()->firstOfMonth()->toDateString();
        $currentDay = Carbon::now()->toDateString();

        $data = $this->getCommonDataForDashboardPage($firstDayOfMonth, $currentDay);
        return view('pages.dashboard.dashboard-page', ['data' => $data]);
    }

    public function search(DashboardSearchRequest $dashboardSearchRequest)
    {
        $dashboardSearchProperties = $dashboardSearchRequest->validated();

        $data = $this->getCommonDataForDashboardPage(
            $dashboardSearchProperties['fromDate'],
            $dashboardSearchProperties['toDate']
        );
        return view('pages.dashboard.dashboard-page', ['data' => $data]);
    }

    public function orderStatisticExportExcel(DashboardExportExcelRequest $dashboardExportExcelRequest)
    {
        $dashboardExportExcelProperties = $dashboardExportExcelRequest->validated();
        $this->dashboardExportExcelService->export(
            $dashboardExportExcelProperties['fromDate'],
            $dashboardExportExcelProperties['toDate'],
        );
    }
}
