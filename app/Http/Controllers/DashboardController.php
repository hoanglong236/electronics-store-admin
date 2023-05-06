<?php

namespace App\Http\Controllers;

use App\Http\Requests\DashboardExportExcelRequest;
use App\Http\Requests\DashboardSearchRequest;
use App\Services\DashboardService;
use App\Services\OrderStatisticsExportExcelService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    private $dashboardService;
    private $orderStatisticsExportExcelService;

    public function __construct()
    {
        $this->dashboardService = new DashboardService();
        $this->orderStatisticsExportExcelService = new OrderStatisticsExportExcelService();
    }

    private function getCommonDataForDashboardPage($fromDate, $toDate)
    {
        $newCustomerCount = $this->dashboardService->getNewCustomerCount($fromDate, $toDate);
        $placedOrderCount = $this->dashboardService->getPlacedOrderCount($fromDate, $toDate);
        $soldItemCount = $this->dashboardService->getSoldItemCount($fromDate, $toDate);
        $orderStatisticsData = $this->dashboardService->getOrderStatisticsData($fromDate, $toDate);
        $catalogStatisticsData = $this->dashboardService->getCatalogStatisticsData($fromDate, $toDate);

        return [
            'pageTitle' => 'Dashboard',
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'newCustomerCount' => $newCustomerCount,
            'placedOrderCount' => $placedOrderCount,
            'soldItemCount' => $soldItemCount,
            'orderStatisticsData' => $orderStatisticsData,
            'catalogStatisticsData' => $catalogStatisticsData,
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

    public function orderStatisticsExportExcel(DashboardExportExcelRequest $dashboardExportExcelRequest)
    {
        $dashboardExportExcelProperties = $dashboardExportExcelRequest->validated();
        $this->orderStatisticsExportExcelService->export(
            $dashboardExportExcelProperties['fromDate'],
            $dashboardExportExcelProperties['toDate'],
        );
    }

    public function categoryStatisticsExportExcel(DashboardExportExcelRequest $dashboardExportExcelRequest)
    {
    }
}
