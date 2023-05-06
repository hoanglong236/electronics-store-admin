<?php

namespace App\Http\Controllers;

use App\Http\Requests\DashboardExportExcelRequest;
use App\Http\Requests\DashboardSearchRequest;
use App\Services\DashboardService;
use App\Services\OrderStatisticExportExcelService;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    private $dashboardService;
    private $orderStatisticExportExcelService;

    public function __construct()
    {
        $this->dashboardService = new DashboardService();
        $this->orderStatisticExportExcelService = new OrderStatisticExportExcelService();
    }

    private function getCommonDataForDashboardPage($fromDate, $toDate)
    {
        $newCustomerCount = $this->dashboardService->getNewCustomerCount($fromDate, $toDate);
        $placedOrderCount = $this->dashboardService->getPlacedOrderCount($fromDate, $toDate);
        $soldItemCount = $this->dashboardService->getSoldItemCount($fromDate, $toDate);
        $orderStatisticData = $this->dashboardService->getOrderStatisticData($fromDate, $toDate);
        $catalogStatisticData = $this->dashboardService->getCatalogStatisticData($fromDate, $toDate);

        return [
            'pageTitle' => 'Dashboard',
            'fromDate' => $fromDate,
            'toDate' => $toDate,
            'newCustomerCount' => $newCustomerCount,
            'placedOrderCount' => $placedOrderCount,
            'soldItemCount' => $soldItemCount,
            'orderStatisticData' => $orderStatisticData,
            'catalogStatisticData' => $catalogStatisticData,
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
        $this->orderStatisticExportExcelService->export(
            $dashboardExportExcelProperties['fromDate'],
            $dashboardExportExcelProperties['toDate'],
        );
    }

    public function categoryStatisticExportExcel(DashboardExportExcelRequest $dashboardExportExcelRequest)
    {
    }
}
