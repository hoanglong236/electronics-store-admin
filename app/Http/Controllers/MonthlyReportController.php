<?php

namespace App\Http\Controllers;

use App\Http\Requests\MonthlyReportSearchRequest;
use App\Services\Exports\MonthlyReportExportExcelService;
use App\Services\MonthlyReportService;
use DateTime;

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
        $currentDate = new DateTime();
        $month = intval($currentDate->format('m'));
        $year = intval($currentDate->format('Y'));

        $data = [];
        $data['monthlyReportData'] = $this->monthlyReportService->getMonthlyReportData($month, $year);
        $data['month'] = $month;
        $data['year'] = $year;
        $data['pageTitle'] = 'Monthly Report';

        return view('pages.monthly-report.monthly-report-page', ['data' => $data]);
    }

    public function search(MonthlyReportSearchRequest $monthlyReportSearchRequest)
    {
        $monthlyReportSearchProps = $monthlyReportSearchRequest->validated();
        $month = $monthlyReportSearchProps['month'];
        $year = $monthlyReportSearchProps['year'];

        $data = [];
        $data['monthlyReportData'] = $this->monthlyReportService->getMonthlyReportData($month, $year);
        $data['month'] = $month;
        $data['year'] = $year;
        $data['pageTitle'] = 'Monthly Report';

        return view('pages.monthly-report.monthly-report-page', ['data' => $data]);
    }

    public function exportExcel(MonthlyReportSearchRequest $monthlyReportSearchRequest)
    {
        $monthlyReportSearchProps = $monthlyReportSearchRequest->validated();

        $this->monthlyReportExportExcelService->export([
            'month' => $monthlyReportSearchProps['month'],
            'year' => $monthlyReportSearchProps['year']
        ]);
    }
}
