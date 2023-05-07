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

    public function export(string $fromDate, string $toDate)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;

        $orderStatisticsData = $this->dashboardService->getOrderStatisticsExportData(
            $this->fromDate,
            $this->toDate
        );

        $currentDate = date('Y-m-d');
        $workbook = new ExcelWorkbook("order_statistics_data_{$currentDate}.xlsx");

        $worksheet = $workbook->getActiveWorksheet();
        $worksheet->setTitle('Order Statistics');
        $worksheet->setPageSetup($this->generatePageSetup());

        $row = 1;
        $row += $this->generateTotalOrderStatusTable($worksheet, $row, $orderStatisticsData['statusCount']);

        // skip 2 rows
        $row += 2;

        $row += $this->generateCustomOrdersTable($worksheet, $row, $orderStatisticsData['customOrders']);

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

    private function generatePageSetup()
    {
        return (new ExcelPageSetup())
            ->setOrientation(ExcelPageSetupConstants::ORIENTATION_LANDSCAPE)
            ->setPrintScale(85)
            ->setPaperSize(ExcelPageSetupConstants::PAPER_SIZE_A4)
            ->setTopMargin(1)
            ->setBottomMargin(1)
            ->setHeader("&C&B&14 ORDER STATISTICS"
                . "&L\n\nFrom: {$this->fromDate} - To: {$this->toDate}")
            ->setFooter("&L&D &T" . "&R&P of &N")
            ->setRepeatRows(1, 10);
    }

    private function generateTotalOrderStatusTable(
        ExcelWorksheet $worksheet,
        int $rowStart,
        array $orderStatusCountArray
    ) {
        $col = 10;
        $row = $rowStart;

        $worksheet->setCellValue($row, $col, 'Status');
        $worksheet->setCellValue($row, $col + 1, 'Total');
        $worksheet->setRangeStyle($row, $row, $col, $col + 1, $this->tableHeaderStyle);
        $row++;

        $tableBodyBoldLeftStyle = $this->generateTableBodyBoldLeftStyle();
        $tableBodyBoldCenterStyle = $this->generateTableBodyBoldCenterStyle();
        $tableBodyIndentLeftStyle = (new ExcelCellStyle())->setBorder()
            ->setHorizontalAlign(ExcelTextAlignmentType::HORIZONTAL_LEFT)
            ->setVerticalAlign(ExcelTextAlignmentType::VERTICAL_CENTER)
            ->setIndent(1);

        $worksheet->setCellValue($row, $col, 'Incomplete');
        $worksheet->setCellStyle($row, $col, $tableBodyBoldLeftStyle);
        $incompleteOrderCount = $orderStatusCountArray[OrderStatusConstants::RECEIVED]
            + $orderStatusCountArray[OrderStatusConstants::PROCESSING]
            + $orderStatusCountArray[OrderStatusConstants::DELIVERING];
        $worksheet->setCellValue($row, $col + 1, $incompleteOrderCount, ExcelCellValueType::NUMERIC);
        $worksheet->setCellStyle($row, $col + 1, $tableBodyBoldCenterStyle);
        $row++;

        foreach ($orderStatusCountArray as $orderStatus => $orderStatusCount) {
            $worksheet->setCellValue($row, $col, $orderStatus);
            $worksheet->setCellValue($row, $col + 1, $orderStatusCount, ExcelCellValueType::NUMERIC);

            if ($orderStatus === OrderStatusConstants::COMPLETED || $orderStatus === OrderStatusConstants::CANCELLED) {
                $worksheet->setCellStyle($row, $col, $tableBodyBoldLeftStyle);
                $worksheet->setCellStyle($row, $col + 1, $tableBodyBoldCenterStyle);
            } else {
                $worksheet->setCellStyle($row, $col, $tableBodyIndentLeftStyle);
                $worksheet->setCellStyle($row, $col + 1, $this->tableBodyCenterStyle);
            }

            $row++;
        }

        $usedRowCount = $row - $rowStart;
        return $usedRowCount;
    }

    private function generateCustomOrdersTable(
        ExcelWorksheet $worksheet,
        int $rowStart,
        array $customOrders
    ) {
        $col = 1;
        $row = $rowStart;

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
        $worksheet->setRangeStyle($row, $row, $col, $col + 10, $this->tableHeaderStyle);
        $row++;


        $tableBodyCurrencyStyle = $this->generateTableBodyCurrencyStyle();

        foreach ($customOrders as $index => $customOrder) {
            $worksheet->setCellValue($row, $col, $index + 1, ExcelCellValueType::NUMERIC);
            $worksheet->setCellValue($row, $col + 1, $customOrder->id, ExcelCellValueType::NUMERIC);
            $worksheet->setRangeStyle($row, $row, $col, $col + 1, $this->tableBodyCenterStyle);

            $worksheet->setCellValue($row, $col + 2, $customOrder->customer_email);
            $worksheet->setCellValue($row, $col + 3, $customOrder->customer_phone);
            $worksheet->setCellValue($row, $col + 4, $customOrder->customer_name);
            $worksheet->setCellValue($row, $col + 5, $customOrder->delivery_address);
            $worksheet->setRangeStyle($row, $row, $col + 2, $col + 5, $this->tableBodyLeftStyle);

            $worksheet->setCellValue($row, $col + 6, $customOrder->status);
            $worksheet->setCellValue($row, $col + 7, $customOrder->payment_method);
            $worksheet->setRangeStyle($row, $row, $col + 6, $col + 7, $this->tableBodyCenterStyle);

            $worksheet->setCellValue($row, $col + 8, $customOrder->created_at);
            $worksheet->setCellValue($row, $col + 9, $customOrder->updated_at);
            $worksheet->setRangeStyle($row, $row, $col + 8, $col + 9, $this->tableBodyLeftStyle);

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
