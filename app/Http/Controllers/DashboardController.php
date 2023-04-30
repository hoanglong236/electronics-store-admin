<?php

namespace App\Http\Controllers;

use App\Libs\Excel\Constants\ExcelBorderLineStyle;
use App\Libs\Excel\Constants\ExcelBorderPosition;
use App\Libs\Excel\ExcelCellStyle;
use App\Libs\Excel\ExcelWorkbook;
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

    public function export()
    {
        $workbook = new ExcelWorkbook("order_details.xlsx");
        $worksheet = $workbook->getActiveWorksheet();

        $headingSheetStyle = new ExcelCellStyle();
        $headingSheetStyle->setFontName('Arial')
            ->setFontSize(14)
            ->setFontBold(true);
        $headingSheetStyle->setBorderProp(ExcelBorderPosition::ALL, ExcelBorderLineStyle::THICK);

        $row = 0;
        $worksheet->mergeCells($row, $row, 0, 3);
        $worksheet->setCellValue($row, 0, 'ORDER DETAILS');
        $worksheet->setCellStyle($row, 0, $headingSheetStyle);
        $worksheet->setCellStyle($row, 1, $headingSheetStyle);
        $worksheet->setCellStyle($row, 2, $headingSheetStyle);
        $worksheet->setCellStyle($row, 3, $headingSheetStyle);
        $row++;

        $row += 2;
        $this->writeTotalOrderStatusTable($row, $worksheet);

        $workbook->download();
    }

    private function writeTotalOrderStatusTable($row, $activeWorksheet)
    {
        $col = 3;

        $activeWorksheet->setCellValue($row, $col, 'Status');
        $activeWorksheet->setCellValue($row, $col + 1, 'Total');
        $row++;

        $activeWorksheet->setCellValue($row, $col, 'Received');
        $activeWorksheet->setCellValue($row, $col + 1, 5);
        $row++;

        $activeWorksheet->setCellValue($row, $col, 'Processing');
        $activeWorksheet->setCellValue($row, $col + 1, 6);
        $row++;

        $activeWorksheet->setCellValue($row, $col, 'Delivering');
        $activeWorksheet->setCellValue($row, $col + 1, 4);
        $row++;

        $activeWorksheet->setCellValue($row, $col, 'Completed');
        $activeWorksheet->setCellValue($row, $col + 1, 8);
        $row++;

        $activeWorksheet->setCellValue($row, $col, 'Cancelled');
        $activeWorksheet->setCellValue($row, $col + 1, 3);
        $row++;
    }
}
