<?php

namespace App\Http\Controllers;

use App\Http\Requests\MonthlyReportSearchRequest;
use App\Services\Exports\MonthlyReportExportExcelService;
use App\Services\MonthlyReportService;
use Illuminate\Http\Request;

class MonthlyReportController extends Controller
{
    private $monthlyReportService;
    private $monthlyReportExportExcelService;

    public function __construct(
        MonthlyReportService $monthlyReportService,
        MonthlyReportExportExcelService $monthlyReportExportExcelService
    ) {
        $this->monthlyReportService = $monthlyReportService;
        $this->monthlyReportExportExcelService = $monthlyReportExportExcelService;
    }

    public function index()
    {
        $currentDate = new \DateTime();
        $month = intval($currentDate->format('m'));
        $year = intval($currentDate->format('Y'));

        $data['pageTitle'] = 'Monthly Report';
        $data['month'] = $month;
        $data['year'] = $year;
        $data['monthlyReportData'] = $this->monthlyReportService->getMonthlyReportData($month, $year);

        return view('pages.monthly-report.monthly-report-page', ['data' => $data]);
    }

    public function search(MonthlyReportSearchRequest $monthlyReportSearchRequest)
    {
        $monthlyReportSearchProperties = $monthlyReportSearchRequest->validated();
        $month = $monthlyReportSearchProperties['month'];
        $year = $monthlyReportSearchProperties['year'];

        $data['pageTitle'] = 'Monthly Report';
        $data['month'] = $month;
        $data['year'] = $year;
        $data['monthlyReportData'] = $this->monthlyReportService->getMonthlyReportData($month, $year);

        return view('pages.monthly-report.monthly-report-page', ['data' => $data]);
    }

    public function exportExcel(MonthlyReportSearchRequest $monthlyReportSearchRequest)
    {
        $monthlyReportSearchProperties = $monthlyReportSearchRequest->validated();
        $month = $monthlyReportSearchProperties['month'];
        $year = $monthlyReportSearchProperties['year'];

        $this->monthlyReportExportExcelService->export([
            'month' => $month,
            'year' => $year
        ]);
    }
}
