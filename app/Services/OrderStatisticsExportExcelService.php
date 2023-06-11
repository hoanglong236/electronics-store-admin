<?php

namespace App\Services;

use App\Libs\Excel\Constants\ExcelCellValueType;
use App\Libs\Excel\Constants\ExcelPageSetupConstants;
use App\Libs\Excel\Constants\ExcelTextAlignmentType;
use App\Libs\Excel\ExcelCellStyle;
use App\Libs\Excel\ExcelPageSetup;
use App\Libs\Excel\ExcelWorkbook;
use App\Libs\Excel\ExcelWorksheet;
use App\Models\Constants\OrderStatusConstants;
use App\Services\DashboardService;

class OrderStatisticsExportExcelService extends BaseExcelService
{
    private $dashboardService;
    private $fromDate;
    private $toDate;

    private $tableHeaderStyle;
    private $tableBodyLeftStyle;
    private $tableBodyCenterStyle;

    public function __construct()
    {
        $this->dashboardService = new DashboardService();

        $this->tableHeaderStyle = $this->generateTableHeaderStyle();
        $this->tableBodyLeftStyle = $this->generateTableBodyLeftStyle();
        $this->tableBodyCenterStyle = $this->generateTableBodyCenterStyle();
    }

    public function export($fromDate, $toDate)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;

        $currentDate = date('Y-m-d');
        $workbook = new ExcelWorkbook("order_statistics_data_{$currentDate}.xlsx");

        $worksheet = $workbook->getActiveWorksheet();
        $worksheet->setTitle('Order Statistics');
        $worksheet->setPageSetup($this->generatePageSetup());

        $this->writeOrderStatisticsToWorksheet($worksheet);

        $col = 1;
        $worksheet->setColumnWidth($col + 2, 25);
        $worksheet->setColumnWidth($col + 3, 40);
        $worksheet->setColumnWidth($col + 4, 12);
        $worksheet->setColumnWidth($col + 6, 11);
        $worksheet->setColumnWidth($col + 7, 13);

        $workbook->download();
    }

    private function generatePageSetup()
    {
        return (new ExcelPageSetup())
            ->setOrientation(ExcelPageSetupConstants::ORIENTATION_LANDSCAPE)
            ->setPrintScale(100)
            ->setPaperSize(ExcelPageSetupConstants::PAPER_SIZE_A4)
            ->setTopMargin(1)
            ->setBottomMargin(1)
            ->setHeader("&C&B&14 ORDER STATISTICS"
                . "&L\n\nFrom: {$this->fromDate} - To: {$this->toDate}")
            ->setFooter("&L&D &T" . "&R&P of &N")
            ->setRepeatRows(1, 9);
    }

    private function writeOrderStatisticsToWorksheet($worksheet)
    {
        $orderStatisticsData = $this->dashboardService->getOrderStatisticsExportData(
            $this->fromDate,
            $this->toDate
        );
        $customOrders = $orderStatisticsData['customOrders'];

        $row = 9;
        $generateCustomOrdersTableResult = $this->generateCustomOrdersTable($worksheet, $row, $customOrders);

        $row = 1;
        $generateTotalOrdersTableResult = $this->generateTotalOrdersTable(
            $worksheet,
            $row,
            $generateCustomOrdersTableResult
        );
    }

    private function generateCustomOrdersTable($worksheet, $rowStart, $customOrders)
    {
        $row = $rowStart;
        $col = 1;

        $worksheet->setCellValue($row, $col, '#');
        $worksheet->setCellValue($row, $col + 1, 'Order ID');
        $worksheet->setCellValue($row, $col + 2, 'Email');
        $worksheet->setCellValue($row, $col + 3, 'Delivery Address');
        $worksheet->setCellValue($row, $col + 4, 'Status');
        $worksheet->setCellValue($row, $col + 5, 'Payment Method');
        $worksheet->setCellValue($row, $col + 6, 'Created At');
        $worksheet->setCellValue($row, $col + 7, 'Total');
        $worksheet->setRangeStyle($row, $row, $col, $col + 7, $this->tableHeaderStyle);
        $row++;

        $tableBodyCurrencyStyle = $this->generateTableBodyCurrencyStyle();

        foreach ($customOrders as $index => $customOrder) {
            $worksheet->setCellValue($row, $col, $index + 1, ExcelCellValueType::NUMERIC);
            $worksheet->setCellValue($row, $col + 1, $customOrder->id, ExcelCellValueType::NUMERIC);
            $worksheet->setRangeStyle($row, $row, $col, $col + 1, $this->tableBodyCenterStyle);

            $worksheet->setCellValue($row, $col + 2, $customOrder->customer_email);
            $worksheet->setCellValue($row, $col + 3, $customOrder->delivery_address);
            $worksheet->setRangeStyle($row, $row, $col + 2, $col + 3, $this->tableBodyLeftStyle);

            $worksheet->setCellValue($row, $col + 4, $customOrder->status);
            $worksheet->setCellValue($row, $col + 5, $customOrder->payment_method);
            $worksheet->setRangeStyle($row, $row, $col + 4, $col + 5, $this->tableBodyCenterStyle);

            $worksheet->setCellValue($row, $col + 6, $customOrder->created_at);
            $worksheet->setCellStyle($row, $col + 6, $this->tableBodyLeftStyle);

            $worksheet->setCellValue($row, $col + 7, $customOrder->total, ExcelCellValueType::NUMERIC);
            $worksheet->setCellStyle($row, $col + 7, $tableBodyCurrencyStyle);

            $row++;
        }

        $customOrderCount = count($customOrders);
        $tableBodyRowStart = $row - $customOrderCount;
        $tableBodyRowEnd = $row - 1;

        $statusColumnAddress = ExcelWorksheet::getColumnAddress($col + 4);
        $statusCellAddressStart = $statusColumnAddress . $tableBodyRowStart;
        $statusCellAddressEnd = $statusColumnAddress . $tableBodyRowEnd;

        $totalColumnAddress = ExcelWorksheet::getColumnAddress($col + 7);
        $totalCellAddressStart = $totalColumnAddress . $tableBodyRowStart;
        $totalCellAddressEnd = $totalColumnAddress . $tableBodyRowEnd;

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
        $worksheet->mergeCells($row, $row, $col + 1, $col + 6);
        $worksheet->setCellValue($row, $col + 1, "Total amount of completed orders:");
        $worksheet->setRangeStyle($row, $row, $col + 1, $col + 6, $tableBodyTotalStyle);

        $totalCompletedOrdersFormula = "=SUMIF({$statusCellAddressStart}:{$statusCellAddressEnd}" .
            ', "Completed", ' . "{$totalCellAddressStart}:{$totalCellAddressEnd})";
        $worksheet->setCellValue($row, $col + 7, $totalCompletedOrdersFormula, ExcelCellValueType::FORMULA);
        $worksheet->setCellStyle($row, $col + 7, $tableBodyCurrencyTotalStyle);
        $row++;

        return [
            'usedRowCount' => $row - $rowStart,
            'tableBodyRowStart' => $tableBodyRowStart,
            'tableBodyRowEnd' => $tableBodyRowEnd,
            'statusColumnAddress' => $statusColumnAddress
        ];
    }

    private function generateTotalOrdersTable($worksheet, $rowStart, $generateCustomOrdersTableResult)
    {
        $row = $rowStart;
        $col = 1;

        $worksheet->setCellValue($row, $col + 6, 'Status');
        $worksheet->setCellValue($row, $col + 7, 'Total Orders');
        $worksheet->setRangeStyle($row, $row, $col + 6, $col + 7, $this->tableHeaderStyle);
        $row++;

        $tableBodyBoldLeftStyle = $this->generateTableBodyBoldLeftStyle();
        $tableBodyBoldRightStyle = $this->generateTableBodyBoldRightStyle();
        $tableBodyRightStyle = $this->generateTableBodyRightStyle();
        $tableBodyIndentLeftStyle = (new ExcelCellStyle())->setBorder()
            ->setHorizontalAlign(ExcelTextAlignmentType::HORIZONTAL_LEFT)
            ->setVerticalAlign(ExcelTextAlignmentType::VERTICAL_CENTER)
            ->setIndent(1);

        $statusColumnAddress = $generateCustomOrdersTableResult['statusColumnAddress'];
        $statusCellAddressStart = $statusColumnAddress . $generateCustomOrdersTableResult['tableBodyRowStart'];
        $statusCellAddressEnd = $statusColumnAddress . $generateCustomOrdersTableResult['tableBodyRowEnd'];

        $orderStatusArray = [
            'Incomplete',
            OrderStatusConstants::RECEIVED,
            OrderStatusConstants::PROCESSING,
            OrderStatusConstants::DELIVERING,
            OrderStatusConstants::COMPLETED,
            OrderStatusConstants::CANCELLED,
        ];

        foreach ($orderStatusArray as $orderStatus) {
            $statusColumnStyle = $tableBodyIndentLeftStyle;
            $totalOrdersColumnStyle = $tableBodyRightStyle;
            $formula = "=COUNTIF({$statusCellAddressStart}:{$statusCellAddressEnd}, "
                . '"' . $orderStatus . '")';

            if (
                $orderStatus === 'Incomplete'
                || $orderStatus === OrderStatusConstants::COMPLETED
                || $orderStatus === OrderStatusConstants::CANCELLED
            ) {
                $statusColumnStyle = $tableBodyBoldLeftStyle;
                $totalOrdersColumnStyle = $tableBodyBoldRightStyle;

                if ($orderStatus === 'Incomplete') {
                    $totalOrdersColumnAddress = ExcelWorksheet::getColumnAddress($col + 7);
                    $incompleteTotalOrdersRowStart = $totalOrdersColumnAddress . ($row + 1);
                    $incompleteTotalOrdersRowEnd = $totalOrdersColumnAddress . ($row + 3);

                    $formula = "=SUM({$incompleteTotalOrdersRowStart}:{$incompleteTotalOrdersRowEnd})";
                }
            }

            $worksheet->setCellValue($row, $col + 6, $orderStatus);
            $worksheet->setCellStyle($row, $col + 6, $statusColumnStyle);

            $worksheet->setCellValue($row, $col + 7, $formula, ExcelCellValueType::FORMULA);
            $worksheet->setCellStyle($row, $col + 7, $totalOrdersColumnStyle);

            $row++;
        }

        return [
            'usedRowCount' => $row - $rowStart,
        ];
    }
}
