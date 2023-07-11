<?php

namespace App\Services\Exports;

use App\Helpers\DateTimeHelper;
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
use Illuminate\Support\Facades\Log;

class MonthlyReportExportExcelService extends ExportExcelService
{
    private $monthlyReportRepository;

    private $tableHeaderStyle;
    private $tableBodyBoldLeftStyle;
    private $tableBodyLeftStyle;
    private $tableBodyRightStyle;
    private $tableTitleStyle;

    private $year;
    private $month;
    private $dayOfMonth;

    public function __construct(IMonthlyReportRepository $monthlyReportRepository)
    {
        $this->monthlyReportRepository = $monthlyReportRepository;

        $this->tableHeaderStyle = $this->generateTableHeaderStyle()
            ->setFontSize(10);
        $this->tableBodyBoldLeftStyle = $this->generateTableBodyBoldLeftStyle()
            ->setFontSize(10);
        $this->tableBodyLeftStyle = $this->generateTableBodyLeftStyle()
            ->setFontSize(10);
        $this->tableBodyRightStyle = $this->generateTableBodyRightStyle()
            ->setFontSize(10);
        $this->tableTitleStyle = (new ExcelCellStyle())
            ->setFontSize(9)
            ->setFontItalic()
            ->setHorizontalAlign(ExcelTextAlignType::HORIZONTAL_CENTER)
            ->setVerticalAlign(ExcelTextAlignType::VERTICAL_BOTTOM);
    }

    protected function getData(array $props)
    {
        $this->year = $props['year'];
        $this->month = $props['month'];
        $this->dayOfMonth = DateTimeHelper::getLastDayOfMonth($this->month, $this->year);

        $orderAnalysisData = $this->monthlyReportRepository
            ->getOrderAnalysisDataByDayOfMonth($this->month, $this->year);

        $orderPlacedQty = 0;
        foreach ($orderAnalysisData as $item) {
            $orderPlacedQty += $item->placed;
        }

        if ($orderPlacedQty === 0) {
            return [];
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
        $worksheet->setRangeStyle($row, $row + 1, $col, $col + 2, $this->tableBodyBoldLeftStyle);

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
            $this->tableBodyBoldLeftStyle
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
        $worksheet->setCellValue($row, $col, "Analysis of orders for the day of month");
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
        Collection $bestSellerItems,
        string $tableTitle
    ) {
        $row = $rowStart;
        $col = $colStart;

        $worksheet->mergeCells($row, $row, $col, $col + 9);
        $worksheet->setCellValue($row, $col, "Name");
        $worksheet->mergeCells($row, $row, $col + 10, $col + 11);
        $worksheet->setCellValue($row, $col + 10, "Qty");
        $worksheet->setRangeStyle($row, $row, $col, $col + 11, $this->tableHeaderStyle);
        $row++;

        foreach ($bestSellerItems as $item) {
            $worksheet->mergeCells($row, $row, $col, $col + 9);
            $worksheet->setCellValue($row, $col, $item->name);
            $worksheet->setRangeStyle($row, $row, $col, $col + 9, $this->tableBodyLeftStyle);

            $worksheet->mergeCells($row, $row, $col + 10, $col + 11);
            $worksheet->setCellValue($row, $col + 10, $item->quantity, ExcelDataType::NUMERIC);
            $worksheet->setRangeStyle($row, $row, $col + 10, $col + 11, $this->tableBodyRightStyle);

            $row++;
        }

        $worksheet->mergeCells($row, $row, $col, $col + 11);
        $worksheet->setCellValue($row, $col, $tableTitle);
        $worksheet->setRangeStyle($row, $row, $col, $col + 11, $this->tableTitleStyle);
        $row++;

        return [
            'usedRowCount' => $row - $rowStart,
        ];
    }

    private function writeBestSellerSection(
        ExcelWorksheet $worksheet, int $rowStart, array $bestSellerData
    ) {
        $row = $rowStart;
        $col = 1;

        $this->writeBestSellerItemsTable(
            $worksheet,
            $row,
            $col,
            $bestSellerData['categories'],
            'Best-seller Categories'
        );
        $this->writeBestSellerItemsTable(
            $worksheet,
            $row,
            $col + 13,
            $bestSellerData['brands'],
            'Best-seller Brands'
        );
        $bestSellerItemsTableInfo = $this->writeBestSellerItemsTable(
            $worksheet,
            $row,
            $col + 26,
            $bestSellerData['products'],
            'Best-seller Products'
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

    private function writeDataSource(
        ExcelWorksheet $worksheet, int $rowStart, array $dataSourceIterator
    ) {
    }

    private function addDataSourceWorksheet(ExcelWorkbook $workbook)
    {
        $worksheet = $workbook->createExcelWorksheet();

        $worksheet->setTitle("Data Source");


        // $worksheet->setPageSetup($this->generatePageSetup([]));
    }

    protected function generateExcel(array $data)
    {
        $monthYearStr = str_pad($this->month, 2, '0', STR_PAD_LEFT) . $this->year;
        $workbook = new ExcelWorkbook("monthly_report_{$monthYearStr}.xlsx");

        $this->addMainWorksheet($workbook, [
            'analysisData' => $data['order']['analysis'],
            'bestSellerData' => $data['bestSellers'],
        ]);
        $this->addDataSourceWorksheet($workbook);

        $workbook->download();
    }
}
