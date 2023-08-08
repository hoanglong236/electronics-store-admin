<?php

namespace App\Services\Exports;

use App\Utils\DateTimeUtil;
use App\Libs\Excel\Constants\ExcelBorderConstants;
use App\Libs\Excel\Constants\ExcelDataType;
use App\Libs\Excel\Constants\ExcelNumberFormatType;
use App\Libs\Excel\Constants\ExcelPageSetupConstants;
use App\Libs\Excel\Constants\ExcelTextAlignType;
use App\Libs\Excel\ExcelCellStyle;
use App\Libs\Excel\ExcelPageSetup;
use App\Libs\Excel\ExcelUtils;
use App\Libs\Excel\ExcelWorkbook;
use App\Libs\Excel\ExcelWorksheet;
use App\Repositories\IMonthlyReportRepository;
use Illuminate\Support\Collection;

class MonthlyReportExportExcelService extends ExportExcelService
{
    private $monthlyReportRepository;

    private $tableHeaderStyle;
    private $tableBodyBoldLeftWrapStyle;
    private $tableBodyLeftStyle;
    private $tableBodyRightStyle;
    private $tableTitleStyle;

    private $year;
    private $month;
    private $dayOfMonth;

    public function __construct(IMonthlyReportRepository $iMonthlyReportRepository)
    {
        $this->monthlyReportRepository = $iMonthlyReportRepository;

        $this->tableHeaderStyle = $this->generateTableHeaderStyle()
            ->setFontSize(10);
        $this->tableBodyBoldLeftWrapStyle = $this->generateTableBodyBoldLeftStyle()
            ->setFontSize(10)
            ->setTextWrap();
        $this->tableBodyLeftStyle = $this->generateTableBodyLeftStyle()
            ->setFontSize(10);
        $this->tableBodyRightStyle = $this->generateTableBodyRightStyle()
            ->setFontSize(10);
        $this->tableTitleStyle = $this->generateTableTitleStyle()
            ->setFontSize(9);
    }

    protected function getData(array $props)
    {
        $this->year = $props['year'];
        $this->month = $props['month'];
        $this->dayOfMonth = DateTimeUtil::getLastDayOfMonth($this->month, $this->year);

        $orderAnalysisData = $this->monthlyReportRepository
            ->getOrderAnalysisDataByDayOfMonth($this->month, $this->year);

        $orderPlacedQty = 0;
        foreach ($orderAnalysisData as $item) {
            $orderPlacedQty += $item->placed;
        }

        $data = [];
        $data['order']['analysis'] = $orderAnalysisData;
        $data['bestSellers']['products'] = $this->monthlyReportRepository
            ->getBestSellerProducts($this->month, $this->year);
        $data['bestSellers']['brands'] = $this->monthlyReportRepository
            ->getBestSellerBrands($this->month, $this->year);
        $data['bestSellers']['categories'] = $this->monthlyReportRepository
            ->getBestSellerCategories($this->month, $this->year);

        return $data;
    }

    private function generatePageSetup(array $pageSetupProps)
    {
        return (new ExcelPageSetup())
            ->setOrientation(ExcelPageSetupConstants::ORIENTATION_LANDSCAPE)
            ->setPrintScale(80)
            ->setPaperSize(ExcelPageSetupConstants::PAPER_SIZE_A4)
            ->setTopMargin(1)
            ->setBottomMargin(1)
            ->setLeftMargin(0.6)
            ->setRightMargin(0.6)
            ->setHeader("&C&B&18 " . $pageSetupProps['headerCenterTitle'])
            ->setFooter("&L&D &T" . "&R&P of &N");
    }

    private function writeTimeLineSection(ExcelWorksheet $worksheet, int $rowStart)
    {
        $row = $rowStart;
        $col = 1;

        $timeSectionStyle = (new ExcelCellStyle())
            ->setFillColor('FFFFFF')
            ->setFontSize(10)
            ->setBorder(ExcelBorderConstants::POSITION_BOTTOM);
        $worksheet->setCellValue($row, $col + 36, "Year:");
        $worksheet->setCellValue($row, $col + 39, $this->year, ExcelDataType::NUMERIC);
        $worksheet->setRangeStyle($row, $row, $col + 36, $col + 39, $timeSectionStyle);
        $worksheet->setCellValue($row + 1, $col + 36, "Month:");
        $worksheet->setCellValue($row + 1, $col + 39, $this->month, ExcelDataType::NUMERIC);
        $worksheet->setRangeStyle($row + 1, $row + 1, $col + 36, $col + 39, $timeSectionStyle);
        $worksheet->setCellValue($row + 2, $col + 36, "Day of month:");
        $worksheet->setCellValue($row + 2, $col + 39, $this->dayOfMonth, ExcelDataType::NUMERIC);
        $worksheet->setRangeStyle($row + 2, $row + 2, $col + 36, $col + 39, $timeSectionStyle);
        $row += 3;

        $worksheet->setColumnWidth($col + 39, 5);

        return [
            'usedRowCount' => $row - $rowStart,
        ];
    }

    private function writeOrderSummarySection(
        ExcelWorksheet $worksheet, int $rowStart, array $analysisSectionInfo
    ) {
        $row = $rowStart;
        $col = 1;

        $worksheet->mergeCells($row, $row + 1, $col, $col + 2);
        $orderQtyCol = $col + 3;
        $worksheet->mergeCells($row, $row + 1, $orderQtyCol, $orderQtyCol + 2);
        $worksheet->setCellValue($row, $orderQtyCol, "Order qty");
        $avgOrderQtyCol = $col + 6;
        $worksheet->mergeCells($row, $row + 1, $avgOrderQtyCol, $avgOrderQtyCol + 2);
        $worksheet->setCellValue($row, $avgOrderQtyCol, "Avg. order qty by day");
        $orderValueCol = $col + 9;
        $worksheet->mergeCells($row, $row + 1, $orderValueCol, $orderValueCol + 3);
        $worksheet->setCellValue($row, $orderValueCol, "Order value");
        $avgTotalOrderValueByDayCol = $col + 13;
        $worksheet->mergeCells($row, $row + 1, $avgTotalOrderValueByDayCol, $avgTotalOrderValueByDayCol + 3);
        $worksheet->setCellValue($row, $avgTotalOrderValueByDayCol, "Avg. total order value by day");
        $avgOrderValueCol = $col + 17;
        $worksheet->mergeCells($row, $row + 1, $avgOrderValueCol, $avgOrderValueCol + 3);
        $worksheet->setCellValue($row, $avgOrderValueCol, "Avg. order value");
        $worksheet->setRangeStyle($row, $row + 1, $col, $avgOrderValueCol + 3, $this->tableHeaderStyle);
        $row += 2;

        $worksheet->mergeCells($row, $row, $col, $col + 2);
        $worksheet->setCellValue($row, $col, "Placed");
        $worksheet->mergeCells($row + 1, $row + 1, $col, $col + 2);
        $worksheet->setCellValue($row + 1, $col, "Cancelled");
        $worksheet->setRangeStyle($row, $row + 1, $col, $col + 2, $this->tableBodyBoldLeftWrapStyle);

        $formula = $analysisSectionInfo['totalOrderPlacedFormula'];
        $worksheet->mergeCells($row, $row, $orderQtyCol, $orderQtyCol + 2);
        $worksheet->setCellValue($row, $orderQtyCol, $formula, ExcelDataType::FORMULA);
        $formula = $analysisSectionInfo['totalOrderCancelledFormula'];
        $worksheet->mergeCells($row + 1, $row + 1, $orderQtyCol, $orderQtyCol + 2);
        $worksheet->setCellValue($row + 1, $orderQtyCol, $formula, ExcelDataType::FORMULA);

        $formula = '=' . ExcelUtils::getCellAddress($row, $orderQtyCol) . '/' . $this->dayOfMonth;
        $worksheet->mergeCells($row, $row, $avgOrderQtyCol, $avgOrderQtyCol + 2);
        $worksheet->setCellValue($row, $avgOrderQtyCol, $formula, ExcelDataType::FORMULA);
        $formula = '=' . ExcelUtils::getCellAddress($row + 1, $orderQtyCol) . '/' . $this->dayOfMonth;
        $worksheet->mergeCells($row + 1, $row + 1, $avgOrderQtyCol, $avgOrderQtyCol + 2);
        $worksheet->setCellValue($row + 1, $avgOrderQtyCol, $formula, ExcelDataType::FORMULA);

        $formula = $analysisSectionInfo['totalOrderPlacedValueFormula'];
        $worksheet->mergeCells($row, $row, $orderValueCol, $orderValueCol + 3);
        $worksheet->setCellValue($row, $orderValueCol, $formula, ExcelDataType::FORMULA);
        $formula = $analysisSectionInfo['totalOrderCancelledValueFormula'];
        $worksheet->mergeCells($row + 1, $row + 1, $orderValueCol, $orderValueCol + 3);
        $worksheet->setCellValue($row + 1, $orderValueCol, $formula, ExcelDataType::FORMULA);

        $formula = '=' . ExcelUtils::getCellAddress($row, $orderValueCol) . '/' . $this->dayOfMonth;
        $worksheet->mergeCells($row, $row, $avgTotalOrderValueByDayCol, $avgTotalOrderValueByDayCol + 3);
        $worksheet->setCellValue($row, $avgTotalOrderValueByDayCol, $formula, ExcelDataType::FORMULA);
        $formula = '=' . ExcelUtils::getCellAddress($row + 1, $orderValueCol) . '/' . $this->dayOfMonth;
        $worksheet->mergeCells($row + 1, $row + 1, $avgTotalOrderValueByDayCol, $avgTotalOrderValueByDayCol + 3);
        $worksheet->setCellValue($row + 1, $avgTotalOrderValueByDayCol, $formula, ExcelDataType::FORMULA);

        $formula = '=' . ExcelUtils::getCellAddress($row, $orderValueCol)
            . '/' . ExcelUtils::getCellAddress($row, $orderQtyCol);
        $worksheet->mergeCells($row, $row, $avgOrderValueCol, $avgOrderValueCol + 3);
        $worksheet->setCellValue($row, $avgOrderValueCol, $formula, ExcelDataType::FORMULA);
        $formula = '=' . ExcelUtils::getCellAddress($row + 1, $orderValueCol)
            . '/' . ExcelUtils::getCellAddress($row + 1, $orderQtyCol);
        $worksheet->mergeCells($row + 1, $row + 1, $avgOrderValueCol, $avgOrderValueCol + 3);
        $worksheet->setCellValue($row + 1, $avgOrderValueCol, $formula, ExcelDataType::FORMULA);

        $tableBodyCellStyle = (new ExcelCellStyle())
            ->setBorder()
            ->setFontSize(10)
            ->setHorizontalAlign(ExcelTextAlignType::HORIZONTAL_RIGHT)
            ->setVerticalAlign(ExcelTextAlignType::VERTICAL_CENTER)
            ->setNumberFormat(ExcelNumberFormatType::NUMBER_COMMA_SEPARATED1);
        $worksheet->setRangeStyle($row, $row + 1, $orderQtyCol, $avgOrderValueCol + 3, $tableBodyCellStyle);
        $row += 2;

        $worksheet->mergeCells($row, $row, $col, $avgOrderValueCol + 3);
        $worksheet->setCellValue($row, $col, "Summary of orders for the month");
        $worksheet->setCellStyle($row, $col, $this->tableTitleStyle);
        $row++;

        return [
            'usedRowCount' => $row - $rowStart,
        ];
    }

    private function writeOrderAnalysisSection(
        ExcelWorksheet $worksheet, int $rowStart, array $analysisData
    ) {
        $row = $rowStart;
        $col = 1;

        $worksheet->mergeCells($row, $row + 1, $col, $col + 2);
        $worksheet->setRangeStyle($row, $row + 1, $col, $col + 2, $this->tableHeaderStyle);

        $worksheet->mergeCells($row, $row, $col + 3, $col + 2 + $this->dayOfMonth);
        $worksheet->setCellValue($row, $col + 3, "Days of month");
        $worksheet->setRangeStyle(
            $row,
            $row,
            $col + 3,
            $col + 2 + $this->dayOfMonth,
            $this->tableHeaderStyle
        );

        $worksheet->mergeCells($row + 2, $row + 3, $col, $col + 2);
        $worksheet->setCellValue($row + 2, $col, "Qty");
        $worksheet->mergeCells($row + 4, $row + 5, $col, $col + 2);
        $worksheet->setCellValue($row + 4, $col, "Total value (in K dollars)");
        $worksheet->setRangeStyle(
            $row + 2,
            $row + 5,
            $col,
            $col + 2,
            $this->tableBodyBoldLeftWrapStyle
        );

        $tableRow = $row + 1;
        $tableCol = $col + 3;
        $placedCellStyle = (new ExcelCellStyle())
            ->setFillColor('B7DEE8')
            ->setBorder()
            ->setFontSize(10)
            ->setVerticalAlign(ExcelTextAlignType::VERTICAL_CENTER)
            ->setHorizontalAlign(ExcelTextAlignType::HORIZONTAL_RIGHT);
        $cancelledCellStyle = (new ExcelCellStyle())
            ->setBorder()
            ->setFontSize(10)
            ->setVerticalAlign(ExcelTextAlignType::VERTICAL_CENTER)
            ->setHorizontalAlign(ExcelTextAlignType::HORIZONTAL_RIGHT);
        foreach ($analysisData as $item) {
            $worksheet->setCellValue($tableRow, $tableCol, $item->day);
            $worksheet->setCellStyle($tableRow, $tableCol, $this->tableHeaderStyle);

            $worksheet->setCellValue($tableRow + 1, $tableCol, $item->placed, ExcelDataType::NUMERIC);
            $worksheet->setCellStyle($tableRow + 1, $tableCol, $placedCellStyle);
            $worksheet->setCellValue($tableRow + 2, $tableCol, $item->cancelled, ExcelDataType::NUMERIC);
            $worksheet->setCellStyle($tableRow + 2, $tableCol, $cancelledCellStyle);
            $worksheet->setCellValue(
                $tableRow + 3,
                $tableCol,
                $item->placed_value / 1000,
                ExcelDataType::NUMERIC
            );
            $worksheet->setCellStyle($tableRow + 3, $tableCol, $placedCellStyle);
            $worksheet->setCellValue(
                $tableRow + 4,
                $tableCol,
                $item->cancelled_value / 1000,
                ExcelDataType::NUMERIC
            );
            $worksheet->setCellStyle($tableRow + 4, $tableCol, $cancelledCellStyle);

            $tableCol++;
        }

        $worksheet->setCellStyle($row + 2, $col + 4 + $this->dayOfMonth, $placedCellStyle);
        $worksheet->setCellStyle($row + 3, $col + 4 + $this->dayOfMonth, $cancelledCellStyle);
        $worksheet->setCellValue($row + 2, $col + 5 + $this->dayOfMonth, "Placed");
        $worksheet->setCellValue($row + 3, $col + 5 + $this->dayOfMonth, "Cancelled");
        $row += 6;

        $worksheet->mergeCells($row, $row, $col, $col + 2 + $this->dayOfMonth);
        $worksheet->setCellValue($row, $col, "Analysis of orders by day of the month");
        $worksheet->setCellStyle($row, $col, $this->tableTitleStyle);
        $row++;

        $tableColStartAddress = ExcelUtils::getColumnAddress($col + 3);
        $tableColEndAddress = ExcelUtils::getColumnAddress($tableCol - 1);

        $totalOrderPlacedFormula = '=SUM(' . $tableColStartAddress . ($tableRow + 1) . ':'
            . $tableColEndAddress . ($tableRow + 1) . ')';
        $totalOrderCancelledFormula = '=SUM(' . $tableColStartAddress . ($tableRow + 2) . ':'
            . $tableColEndAddress . ($tableRow + 2) . ')';
        $totalOrderPlacedValueFormula = '=SUM(' . $tableColStartAddress . ($tableRow + 3) . ':'
            . $tableColEndAddress . ($tableRow + 3) . ')';
        $totalOrderCancelledValueFormula = '=SUM(' . $tableColStartAddress . ($tableRow + 4) . ':'
            . $tableColEndAddress . ($tableRow + 4) . ')';

        return [
            'usedRowCount' => $row - $rowStart,
            'totalOrderPlacedFormula' => $totalOrderPlacedFormula,
            'totalOrderCancelledFormula' => $totalOrderCancelledFormula,
            'totalOrderPlacedValueFormula' => $totalOrderPlacedValueFormula,
            'totalOrderCancelledValueFormula' => $totalOrderCancelledValueFormula,
        ];
    }

    private function writeBestSellerItemsTable(
        ExcelWorksheet $worksheet,
        int $rowStart,
        int $colStart,
        int $numberColumnsForNameColumn,
        string $tableTitle,
        Collection $bestSellerItems
    ) {
        $row = $rowStart;
        $col = $colStart;

        $numberColumnsForQtyColumn = 2;

        $nameColStart = $col;
        $nameColEnd = $nameColStart + $numberColumnsForNameColumn - 1;
        $qtyColStart = $nameColEnd + 1;
        $qtyColEnd = $qtyColStart + $numberColumnsForQtyColumn - 1;

        $worksheet->mergeCells($row, $row, $nameColStart, $nameColEnd);
        $worksheet->setCellValue($row, $nameColStart, "Name");
        $worksheet->mergeCells($row, $row, $qtyColStart, $qtyColEnd);
        $worksheet->setCellValue($row, $qtyColStart, "Qty");
        $worksheet->setRangeStyle($row, $row, $nameColStart, $qtyColEnd, $this->tableHeaderStyle);
        $row++;

        foreach ($bestSellerItems as $item) {
            $worksheet->mergeCells($row, $row, $nameColStart, $nameColEnd);
            $worksheet->setCellValue($row, $nameColStart, $item->name);
            $worksheet->setRangeStyle($row, $row, $nameColStart, $nameColEnd, $this->tableBodyLeftStyle);

            $worksheet->mergeCells($row, $row, $qtyColStart, $qtyColEnd);
            $worksheet->setCellValue($row, $qtyColStart, $item->quantity, ExcelDataType::NUMERIC);
            $worksheet->setRangeStyle($row, $row, $qtyColStart, $qtyColEnd, $this->tableBodyRightStyle);

            $row++;
        }

        $worksheet->mergeCells($row, $row, $nameColStart, $qtyColEnd);
        $worksheet->setCellValue($row, $nameColStart, $tableTitle);
        $worksheet->setRangeStyle($row, $row, $nameColStart, $qtyColEnd, $this->tableTitleStyle);
        $row++;
        $col = $qtyColEnd + 1;

        return [
            'usedRowCount' => $row - $rowStart,
            'usedColumnCount' => $col - $colStart,
        ];
    }

    private function writeBestSellerSection(
        ExcelWorksheet $worksheet, int $rowStart, array $bestSellerData
    ) {
        $row = $rowStart;
        $col = 1;

        $bestSellerItemsTableInfo = $this->writeBestSellerItemsTable(
            $worksheet,
            $row,
            $col,
            7,
            'Best-seller Categories',
            $bestSellerData['categories']
        );
        $col += $bestSellerItemsTableInfo['usedColumnCount'];

        $bestSellerItemsTableInfo = $this->writeBestSellerItemsTable(
            $worksheet,
            $row,
            $col + 1,
            7,
            'Best-seller Brands',
            $bestSellerData['brands']
        );
        $col += 1 + $bestSellerItemsTableInfo['usedColumnCount'];

        $bestSellerItemsTableInfo = $this->writeBestSellerItemsTable(
            $worksheet,
            $row,
            $col + 1,
            10,
            'Best-seller Products',
            $bestSellerData['products']
        );
        $row += $bestSellerItemsTableInfo['usedRowCount'];

        return [
            'usedRowCount' => $row - $rowStart,
        ];
    }

    private function addMainWorksheet(ExcelWorkbook $workbook, array $data)
    {
        $worksheet = $workbook->getActiveWorksheet();

        $worksheet->setTitle("Monthly Report");
        $worksheet->setDefaultColumnWidth(4);

        $row = 1;

        $timeLineSectionInfo = $this->writeTimeLineSection($worksheet, $row);
        $row += $timeLineSectionInfo['usedRowCount'];

        $analysisSectionInfo = $this->writeOrderAnalysisSection($worksheet, $row + 8, $data['analysisData']);
        $this->writeOrderSummarySection($worksheet, $row + 1, $analysisSectionInfo);
        $row = $row + 8 + $analysisSectionInfo['usedRowCount'];

        $bestSellerSectionInfo = $this->writeBestSellerSection($worksheet, $row + 2, $data['bestSellerData']);
        $row = $row + 2 + $bestSellerSectionInfo['usedRowCount'];

        $worksheet->setPageSetup($this->generatePageSetup([
            'headerCenterTitle' => 'MONTHLY REPORT',
        ]));
    }

    protected function generateExcel(array $data)
    {
        $monthYearStr = str_pad($this->month, 2, '0', STR_PAD_LEFT) . $this->year;
        $workbook = new ExcelWorkbook("monthly_report_{$monthYearStr}.xlsx");

        $this->addMainWorksheet($workbook, [
            'analysisData' => $data['order']['analysis'],
            'bestSellerData' => $data['bestSellers'],
        ]);

        $workbook->download();
    }
}
