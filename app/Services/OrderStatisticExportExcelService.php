<?php

namespace App\Services;

use App\Libs\Excel\Constants\ExcelCellValueType;
use App\Libs\Excel\Constants\ExcelPageSetupConstants;
use App\Libs\Excel\Constants\ExcelTextAlignmentType;
use App\Libs\Excel\ExcelCellStyle;
use App\Libs\Excel\ExcelPageSetup;
use App\Libs\Excel\ExcelWorkbook;
use App\Libs\Excel\ExcelWorksheet;
use App\ModelConstants\OrderStatusConstants;
use App\Services\DashboardService;

class OrderStatisticExportExcelService extends BaseExcelService
{
    private $dashboardService;

    public function __construct()
    {
        $this->dashboardService = new DashboardService();
    }

    public function export(string $fromDate, string $toDate)
    {
        $orderStatisticData = $this->dashboardService->getOrderStatisticExportData($fromDate, $toDate);
        $currentDate = date('Y-m-d');

        $workbook = new ExcelWorkbook("order_statistic_data_{$currentDate}.xlsx");
        $worksheet = $workbook->getActiveWorksheet();
        $worksheet->setTitle('Order Statistic');
        $worksheet->setPageSetup($this->generatePageSetup($fromDate, $toDate));

        $row = 1;
        $row += $this->generateTotalOrderStatusTable($row, $worksheet, $orderStatisticData['statusCount']);

        // skip next 2 rows
        $row += 2;

        $row += $this->generateCustomOrdersTable($row, $worksheet, $orderStatisticData['customOrders']);

        $col = 1;
        $worksheet->setColumnWidth($col + 2, 20);
        $worksheet->setColumnWidth($col + 3, 12);
        $worksheet->setColumnWidth($col + 4, 15);
        $worksheet->setColumnWidth($col + 5, 30);
        $worksheet->setColumnWidth($col + 6, 12);
        $worksheet->setColumnWidth($col + 8, 11);
        $worksheet->setColumnWidth($col + 9, 11);
        $worksheet->setColumnWidth($col + 10, 13);

        $workbook->download();
    }

    private function generatePageSetup($fromDate, $toDate)
    {
        return (new ExcelPageSetup())
            ->setOrientation(ExcelPageSetupConstants::ORIENTATION_LANDSCAPE)
            ->setPrintScale(85)
            ->setPaperSize(ExcelPageSetupConstants::PAPER_SIZE_A4)
            ->setTopMargin(1)
            ->setBottomMargin(1)
            ->setHeader("&C&B&14 ORDER STATISTIC" . "&L\n\nFrom: {$fromDate} - To: {$toDate}")
            ->setFooter("&L&D &T" . "&R&P of &N")
            ->setRepeatRows(1, 10);
    }

    private function generateTotalOrderStatusTable(int $rowStart, ExcelWorksheet $worksheet, array $orderStatusCountArray)
    {
        $col = 10;
        $row = $rowStart;
        $tableHeaderStyle = $this->generateTableHeaderStyle();

        $worksheet->setCellValue($row, $col, 'Status');
        $worksheet->setCellValue($row, $col + 1, 'Total');
        $worksheet->setRangeStyle($row, $row, $col, $col + 1, $tableHeaderStyle);
        $row++;

        $tableMainCellLeftStyle = $this->generateTableBodyBoldLeftStyle();
        $tableMainCellCenterStyle = $this->generateTableBodyBoldCenterStyle();
        $tableSubCellIndentStyle = (new ExcelCellStyle())->setBorder()
            ->setHorizontalAlign(ExcelTextAlignmentType::HORIZONTAL_LEFT)
            ->setIndent(1);
        $tableSubCellCenterStyle = $this->generateTableBodyCenterStyle();

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

        $usedRowCount = $row - $rowStart;
        return $usedRowCount;
    }

    private function generateCustomOrdersTable(int $rowStart, ExcelWorksheet $worksheet, $customOrders)
    {
        $col = 1;
        $row = $rowStart;

        $tableHeaderStyle = $this->generateTableHeaderStyle();
        $worksheet->setCellValue($row, $col, '#');
        $worksheet->setCellValue($row, $col + 1, 'Order ID');
        $worksheet->setCellValue($row, $col + 2, 'Email');
        $worksheet->setCellValue($row, $col + 3, 'Phone');
        $worksheet->setCellValue($row, $col + 4, 'Customer Name');
        $worksheet->setCellValue($row, $col + 5, 'Delivery Address');
        $worksheet->setCellValue($row, $col + 6, 'Status');
        $worksheet->setCellValue($row, $col + 7, 'Payment Method');
        $worksheet->setCellValue($row, $col + 8, 'Created At');
        $worksheet->setCellValue($row, $col + 9, 'Updated At');
        $worksheet->setCellValue($row, $col + 10, 'Total');
        $worksheet->setRangeStyle($row, $row, $col, $col + 10, $tableHeaderStyle);
        $row++;

        $tableBodyLeftStyle = $this->generateTableBodyLeftStyle();
        $tableBodyCenterStyle = $this->generateTableBodyCenterStyle();
        $tableBodyCurrencyStyle = $this->generateTableBodyCurrencyStyle();

        foreach ($customOrders as $index => $customOrder) {
            $worksheet->setCellValue($row, $col, $index + 1, ExcelCellValueType::NUMERIC);
            $worksheet->setCellValue($row, $col + 1, $customOrder->id, ExcelCellValueType::NUMERIC);
            $worksheet->setRangeStyle($row, $row, $col, $col + 1, $tableBodyCenterStyle);

            $worksheet->setCellValue($row, $col + 2, $customOrder->customer_email);
            $worksheet->setCellValue($row, $col + 3, $customOrder->customer_phone);
            $worksheet->setCellValue($row, $col + 4, $customOrder->customer_name);
            $worksheet->setCellValue($row, $col + 5, $customOrder->delivery_address);
            $worksheet->setRangeStyle($row, $row, $col + 2, $col + 5, $tableBodyLeftStyle);

            $worksheet->setCellValue($row, $col + 6, $customOrder->status);
            $worksheet->setCellValue($row, $col + 7, $customOrder->payment_method);
            $worksheet->setRangeStyle($row, $row, $col + 6, $col + 7, $tableBodyCenterStyle);

            $worksheet->setCellValue($row, $col + 8, $customOrder->created_at);
            $worksheet->setCellValue($row, $col + 9, $customOrder->updated_at);
            $worksheet->setRangeStyle($row, $row, $col + 8, $col + 9, $tableBodyLeftStyle);

            $worksheet->setCellValue($row, $col + 10, $customOrder->total, ExcelCellValueType::NUMERIC);
            $worksheet->setCellStyle($row, $col + 10, $tableBodyCurrencyStyle);

            $row++;
        }

        $customOrderCount = count($customOrders);
        $tableBodyRowStart = $row - $customOrderCount;
        $tableBodyRowEnd = $row - 1;

        $tableBodyCenterBoldFillStyle = $this->generateTableBodyBoldCenterStyle()
            ->setFillColor('ffff99');
        $tableBodyTotalStyle = $this->generateTableBodyBoldRightStyle()
            ->setFontSize(12)
            ->setFillColor('ffff99')
            ->setIndent(1);
        $tableBodyCurrencyTotalStyle = $this->generateTableBodyBoldCurrencyStyle()
            ->setFillColor('ffff99');

        $worksheet->setCellValue($row, $col, $customOrderCount + 1, ExcelCellValueType::NUMERIC);
        $worksheet->setCellStyle($row, $col, $tableBodyCenterBoldFillStyle);
        $worksheet->mergeCells($row, $row, $col + 1, $col + 9);
        $worksheet->setCellValue($row, $col + 1, "Total amount of completed orders:");
        $worksheet->setRangeStyle($row, $row, $col + 1, $col + 9, $tableBodyTotalStyle);

        $sumIfFormula = "=SUMIF(G" . $tableBodyRowStart . ":G" . $tableBodyRowEnd .
            ', "Completed", K' . $tableBodyRowStart . ":K" . $tableBodyRowEnd . ")";
        $worksheet->setCellValue($row, $col + 10, $sumIfFormula, ExcelCellValueType::FORMULA);
        $worksheet->setCellStyle($row, $col + 10, $tableBodyCurrencyTotalStyle);
        $row++;

        $usedRowCount = $row - $rowStart;
        return $usedRowCount;
    }
}
