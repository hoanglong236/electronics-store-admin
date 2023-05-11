<?php

namespace App\Services;

use App\Libs\Excel\Constants\ExcelCellValueType;
use App\Libs\Excel\Constants\ExcelPageSetupConstants;
use App\Libs\Excel\ExcelCellStyle;
use App\Libs\Excel\ExcelPageSetup;
use App\Libs\Excel\ExcelWorkbook;
use App\Libs\Excel\ExcelWorksheet;
use Illuminate\Support\Facades\Log;
use App\Services\DashboardService;

class CatalogStatisticsExportExcelService extends BaseExcelService
{
    private $dashboardService;
    private $fromDate;
    private $toDate;

    private $titleStyle;
    private $tableHeaderStyle;
    private $tableBodyLeftStyle;
    private $tableBodyCenterStyle;
    private $tableBodyRightStyle;
    private $tableBodyLinkLeftStyle;

    public function __construct()
    {
        $this->dashboardService = new DashboardService();

        $this->titleStyle = (new ExcelCellStyle())->setFontSize(13)
            ->setFontBold();
        $this->tableHeaderStyle = $this->generateTableHeaderStyle();
        $this->tableBodyLeftStyle = $this->generateTableBodyLeftStyle();
        $this->tableBodyCenterStyle = $this->generateTableBodyCenterStyle();
        $this->tableBodyRightStyle = $this->generateTableBodyRightStyle();
        $this->tableBodyLinkLeftStyle = $this->generateTableBodyLeftStyle()
            ->setFontColor('0000ff')
            ->setFontUnderline();
    }

    public function export(string $fromDate, string $toDate)
    {
        $this->fromDate = $fromDate;
        $this->toDate = $toDate;

        $currentDate = date('Y-m-d');
        $workbook = new ExcelWorkbook("catalog_statistics_data_{$currentDate}.xlsx");

        $catalogStatisticsData = $this->dashboardService->getCatalogStatisticsExportData($fromDate, $toDate);

        $worksheet = $workbook->getActiveWorksheet();
        $worksheet->setTitle('Categories');
        $worksheet->setPageSetup($this->generatePageSetup('BEST-SELLING CATEGORIES STATISTICS'));
        $this->writeBestSellingCategories($worksheet, $catalogStatisticsData['bestSellingCategories']);

        foreach ($catalogStatisticsData['bestSellingCategories'] as $bestSellingCategory) {
            $worksheet = $workbook->createExcelWorksheet();
            $worksheet->setTitle($bestSellingCategory['name']);
            $worksheet->setPageSetup($this->generatePageSetup("BEST-SELLING OF " .
                strtoupper($bestSellingCategory['name'])));
            $this->writeBestSellingCategoryDetails($worksheet, $bestSellingCategory);
        }

        $workbook->download();
    }

    private function generatePageSetup(string $centerHeader = '')
    {
        return (new ExcelPageSetup())
            ->setOrientation(ExcelPageSetupConstants::ORIENTATION_PORTRAIT)
            ->setPrintScale(100)
            ->setPaperSize(ExcelPageSetupConstants::PAPER_SIZE_A4)
            ->setTopMargin(1)
            ->setBottomMargin(1)
            ->setHeader("&C&B&14 {$centerHeader}"
                . "&L\n\nFrom: {$this->fromDate} - To: {$this->toDate}")
            ->setFooter("&L&D &T" . "&R&P of &N")
            ->setRepeatRows(1, 10);
    }

    private function writeBestSellingCategories(
        ExcelWorksheet $worksheet,
        array $bestSellingCategories
    ) {
        $row = 1;
        $col = 1;

        $worksheet->setCellValue($row, $col, 'Category Statistics');
        $worksheet->setCellStyle($row, $col, $this->titleStyle);
        $row++;

        $row += $this->writeBestSellingCategoriesTable(
            $worksheet,
            $row,
            $bestSellingCategories
        );

        $worksheet->setColumnWidth(2, 15);
        $worksheet->setColumnWidth(3, 13);
    }

    private function writeBestSellingCategoriesTable(
        ExcelWorksheet $worksheet,
        int $rowStart,
        array $bestSellingCategories
    ) {
        $row = $rowStart;
        $col = 1;

        $worksheet->setCellValue($row, $col, '#');
        $worksheet->setCellValue($row, $col + 1, 'Category Name');
        $worksheet->setCellValue($row, $col + 2, 'Sold Quantity');
        $worksheet->setRangeStyle($row, $row, $col, $col + 2, $this->tableHeaderStyle);
        $row++;

        foreach ($bestSellingCategories as $index => $bestSellingCategory) {
            $worksheet->setCellValue($row, $col, $index + 1, ExcelCellValueType::NUMERIC);
            $worksheet->setCellStyle($row, $col, $this->tableBodyCenterStyle);

            $worksheet->setHyperlink(
                $row,
                $col + 1,
                $bestSellingCategory['name'],
                "sheet://'{$bestSellingCategory['name']}'!A1"
            );
            $worksheet->setCellStyle($row, $col + 1, $this->tableBodyLinkLeftStyle);

            $worksheet->setCellValue(
                $row,
                $col + 2,
                $bestSellingCategory['soldQuantity'],
                ExcelCellValueType::NUMERIC
            );
            $worksheet->setCellStyle($row, $col + 2, $this->tableBodyRightStyle);

            $row++;
        }

        $usedRowCount = $row - $rowStart;
        return $usedRowCount;
    }

    private function writeBestSellingCategoryDetails(ExcelWorksheet $worksheet, array $categoryDetails)
    {
        $row = 1;
        $col = 1;

        $worksheet->setCellValue($row, $col, "{$categoryDetails['name']} Statistics");
        $worksheet->setCellStyle($row, $col, $this->titleStyle);
        $row++;

        $row += $this->writeBestSellingBrandsTable(
            $worksheet,
            $row,
            $categoryDetails['bestSellingBrands'],
            $categoryDetails['soldQuantity']
        );

        // skip a row
        $row++;

        foreach ($categoryDetails['bestSellingBrands'] as $index => $bestSellingBrand) {
            // skip a row
            $row++;

            $worksheet->setCellValue($row, $col, "{$bestSellingBrand['name']} Statistics");
            $worksheet->setCellStyle($row, $col, $this->titleStyle);
            $row++;

            $row += $this->writeBestSellingProductsTable(
                $worksheet,
                $row,
                $bestSellingBrand['bestSellingProducts'],
                $bestSellingBrand['soldQuantity']
            );
        }

        $worksheet->setColumnWidth(2, 20);
    }

    private function writeBestSellingBrandsTable(
        ExcelWorksheet $worksheet,
        int $rowStart,
        array $bestSellingBrands,
        int $categorySoldQuantity
    ) {
        $row = $rowStart;
        $col = 1;

        $worksheet->setCellValue($row, $col, '#');
        $worksheet->setCellValue($row, $col + 1, 'Brand Name');
        $worksheet->setCellValue($row, $col + 2, 'Sold Quantity');
        $worksheet->setRangeStyle($row, $row, $col, $col + 2, $this->tableHeaderStyle);
        $row++;

        $othersSoldQuantity = $categorySoldQuantity;
        foreach ($bestSellingBrands as $index => $bestSellingBrand) {
            $worksheet->setCellValue($row, $col, $index + 1, ExcelCellValueType::NUMERIC);
            $worksheet->setCellStyle($row, $col, $this->tableBodyCenterStyle);

            $worksheet->setCellValue($row, $col + 1, $bestSellingBrand['name']);
            $worksheet->setCellStyle($row, $col + 1, $this->tableBodyLeftStyle);

            $worksheet->setCellValue(
                $row,
                $col + 2,
                $bestSellingBrand['soldQuantity'],
                ExcelCellValueType::NUMERIC
            );
            $worksheet->setCellStyle($row, $col + 2, $this->tableBodyRightStyle);

            $row++;
            $othersSoldQuantity -= $bestSellingBrand['soldQuantity'];
        }

        if ($othersSoldQuantity > 0) {
            $worksheet->setCellValue(
                $row,
                $col,
                count($bestSellingBrands) + 1,
                ExcelCellValueType::NUMERIC
            );
            $worksheet->setCellStyle($row, $col, $this->tableBodyCenterStyle);

            $worksheet->setCellValue($row, $col + 1, 'Others');
            $worksheet->setCellStyle($row, $col + 1, $this->tableBodyLeftStyle);

            $worksheet->setCellValue(
                $row,
                $col + 2,
                $othersSoldQuantity,
                ExcelCellValueType::NUMERIC
            );
            $worksheet->setCellStyle($row, $col + 2, $this->tableBodyRightStyle);

            $row++;
        }

        $usedRowCount = $row - $rowStart;
        return $usedRowCount;
    }

    private function writeBestSellingProductsTable(
        ExcelWorksheet $worksheet,
        int $rowStart,
        array $bestSellingProducts,
        int $brandSoldQuantity,
    ) {
        $row = $rowStart;
        $col = 1;

        $worksheet->setCellValue($row, $col, '#');
        $worksheet->setCellValue($row, $col + 1, 'Product Name');
        $worksheet->setCellValue($row, $col + 2, 'Sold Quantity');
        $worksheet->setRangeStyle($row, $row, $col, $col + 2, $this->tableHeaderStyle);
        $row++;

        $othersSoldQuantity = $brandSoldQuantity;
        foreach ($bestSellingProducts as $index => $bestSellingProduct) {
            $worksheet->setCellValue($row, $col, $index + 1, ExcelCellValueType::NUMERIC);
            $worksheet->setCellStyle($row, $col, $this->tableBodyCenterStyle);

            $worksheet->setCellValue($row, $col + 1, $bestSellingProduct['name']);
            $worksheet->setCellStyle($row, $col + 1, $this->tableBodyLeftStyle);

            $worksheet->setCellValue(
                $row,
                $col + 2,
                $bestSellingProduct['soldQuantity'],
                ExcelCellValueType::NUMERIC
            );
            $worksheet->setCellStyle($row, $col + 2, $this->tableBodyRightStyle);

            $row++;
            $othersSoldQuantity -= $bestSellingProduct['soldQuantity'];
        }

        if ($othersSoldQuantity > 0) {
            $worksheet->setCellValue(
                $row,
                $col,
                count($bestSellingProducts) + 1,
                ExcelCellValueType::NUMERIC
            );
            $worksheet->setCellStyle($row, $col, $this->tableBodyCenterStyle);

            $worksheet->setCellValue($row, $col + 1, 'Others');
            $worksheet->setCellStyle($row, $col + 1, $this->tableBodyLeftStyle);

            $worksheet->setCellValue(
                $row,
                $col + 2,
                $othersSoldQuantity,
                ExcelCellValueType::NUMERIC
            );
            $worksheet->setCellStyle($row, $col + 2, $this->tableBodyRightStyle);

            $row++;
        }

        $usedRowCount = $row - $rowStart;
        return $usedRowCount;
    }
}
