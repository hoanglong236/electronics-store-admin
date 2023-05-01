<?php

namespace App\Services;

use App\Libs\Excel\Constants\ExcelBorderLineStyle;
use App\Libs\Excel\Constants\ExcelBorderPosition;
use App\Libs\Excel\Constants\ExcelCellValueType;
use App\Libs\Excel\Constants\ExcelTextAlignmentType;
use App\Libs\Excel\ExcelCellStyle;
use App\Libs\Excel\ExcelWorkbook;
use App\ModelConstants\OrderStatusConstants;
use App\Services\DashboardService;

class DashboardExportExcelService
{
    private $dashboardService;

    public function __construct()
    {
        $this->dashboardService = new DashboardService();
    }

    public function export($fromDate, $toDate)
    {
        $orderStatisticData = $this->dashboardService->getOrderStatisticData($fromDate, $toDate);

        $workbook = new ExcelWorkbook("order_details.xlsx");
        $worksheet = $workbook->getActiveWorksheet();

        $row = 0;
        $this->writeHeadingSheetRow($row, $worksheet);
        $row++;

        $row += 2;
        $this->writeTotalOrderStatusTable($row, $worksheet, $orderStatisticData['statusCount']);

        $workbook->download();
    }

    private function writeHeadingSheetRow($row, $worksheet)
    {
        $headingSheetStyle = new ExcelCellStyle();
        $headingSheetStyle->setFontSize(14)
            ->setFontBold(true)
            ->setBorderProp(ExcelBorderPosition::ALL, ExcelBorderLineStyle::THICK);

        $worksheet->mergeCells($row, $row, 0, 3);
        $worksheet->setCellValue($row, 0, 'ORDER DETAILS');
        $worksheet->setRangeStyle($row, $row, 0, 3, $headingSheetStyle);
    }

    private function writeTotalOrderStatusTable($row, $worksheet, $orderStatusCountArray)
    {
        $col = 3;
        $tableHeaderStyle = $this->generateTableHeaderStyle();

        $worksheet->setCellValue($row, $col, 'Status');
        $worksheet->setCellValue($row, $col + 1, 'Total');
        $worksheet->setRangeStyle($row, $row, $col, $col + 1, $tableHeaderStyle);
        $row++;

        $tableMainCellLeftStyle = (new ExcelCellStyle())
            ->setFontBold(true)
            ->setBorderProp(ExcelBorderPosition::ALL)
            ->setHorizontalAlign(ExcelTextAlignmentType::HORIZONTAL_LEFT);
        $tableMainCellCenterStyle = (new ExcelCellStyle())
            ->setFontBold(true)
            ->setBorderProp(ExcelBorderPosition::ALL)
            ->setHorizontalAlign(ExcelTextAlignmentType::HORIZONTAL_CENTER);
        $tableSubCellIndentStyle = (new ExcelCellStyle())
            ->setBorderProp(ExcelBorderPosition::ALL)
            ->setHorizontalAlign(ExcelTextAlignmentType::HORIZONTAL_LEFT)
            ->setIndent(1);
        $tableSubCellCenterStyle = (new ExcelCellStyle())
            ->setBorderProp(ExcelBorderPosition::ALL)
            ->setHorizontalAlign(ExcelTextAlignmentType::HORIZONTAL_CENTER);

        $worksheet->setCellValue($row, $col, 'Incomplete');
        $worksheet->setCellStyle($row, $col, $tableMainCellLeftStyle);
        $incompleteOrderCount = $orderStatusCountArray[OrderStatusConstants::RECEIVED]
            + $orderStatusCountArray[OrderStatusConstants::PROCESSING]
            + $orderStatusCountArray[OrderStatusConstants::DELIVERING];
        $worksheet->setCellValue($row, $col + 1, $incompleteOrderCount, ExcelCellValueType::NUMERIC);
        $worksheet->setCellStyle($row, $col + 1, $tableMainCellCenterStyle);
        $row++;

        foreach ($orderStatusCountArray as $orderStatus => $orderStatusCount) {
            $worksheet->setCellValue($row, $col, $orderStatus);
            $worksheet->setCellValue($row, $col + 1, $orderStatusCount, ExcelCellValueType::NUMERIC);

            if ($orderStatus === OrderStatusConstants::COMPLETED || $orderStatus === OrderStatusConstants::CANCELLED) {
                $worksheet->setCellStyle($row, $col, $tableMainCellLeftStyle);
                $worksheet->setCellStyle($row, $col + 1, $tableMainCellCenterStyle);
            } else {
                $worksheet->setCellStyle($row, $col, $tableSubCellIndentStyle);
                $worksheet->setCellStyle($row, $col + 1, $tableSubCellCenterStyle);
            }

            $row++;
        }
    }

    private function generateTableHeaderStyle()
    {
        return (new ExcelCellStyle())->setFontBold(true)
            ->setBorderProp(ExcelBorderPosition::ALL)
            ->setHorizontalAlign(ExcelTextAlignmentType::HORIZONTAL_CENTER)
            ->setTextWrap(true)
            ->setFillProps('f8f700');
    }
}
