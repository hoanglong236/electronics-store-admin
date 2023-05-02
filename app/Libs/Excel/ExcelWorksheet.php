<?php

namespace App\Libs\Excel;

use App\Libs\Excel\Constants\ExcelCellValueType;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\Hyperlink;
use PhpOffice\PhpSpreadsheet\Style\Style;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class ExcelWorksheet
{
    private $worksheet;

    public function __construct(Worksheet $worksheet)
    {
        $this->worksheet = $worksheet;
    }

    public function setCellValue(
        int $row,
        int $col,
        $value,
        string $dataType = ExcelCellValueType::STRING
    ) {
        $this->worksheet->setCellValueExplicit([$col + 1, $row + 1], $value, $dataType);
    }

    /**
     * Set a HyperLink.
     *
     * @param string $url Url to link the cell to
     * @param string $tooltip Tooltip to display on the hyperlink
     */
    public function setHyperlink(
        int $row,
        int $col,
        string $value,
        bool $addLinkStyle,
        string $url,
        string $tooltip = '',
    ) {
        $this->setCellValue($row, $col, $value);
        if ($addLinkStyle) {
            $hyperLinkStyle = (new ExcelCellStyle())
                ->setFontColor('4287f5')
                ->setFontUnderline();
            $this->setCellStyle($row, $col, $hyperLinkStyle);
        }

        $cellAddress = static::getCellAddress($row, $col);
        $this->worksheet->setHyperlink($cellAddress, new Hyperlink($url, $tooltip));
    }

    public function setCellStyle(int $row, int $col, ExcelCellStyle $excelCellStyle)
    {
        $styleToApply = $this->worksheet->getStyle([$col + 1, $row + 1]);
        $this->applyStyleFromExcelCellStyle($styleToApply, $excelCellStyle);
    }

    public function setRangeStyle(
        int $rowStart,
        int $rowEnd,
        int $colStart,
        int $colEnd,
        ExcelCellStyle $excelCellStyle
    ) {
        $styleToApply = $this->worksheet->getStyle([$colStart + 1, $rowStart + 1, $colEnd + 1, $rowEnd + 1]);
        $this->applyStyleFromExcelCellStyle($styleToApply, $excelCellStyle);
    }

    private function applyStyleFromExcelCellStyle(Style &$styleToApply, ExcelCellStyle $excelCellStyle)
    {
        $fontProps = $excelCellStyle->getFontProps();
        if (count($fontProps) > 0) {
            $styleToApply->getFont()->applyFromArray($fontProps);
        }

        $borderProps = $excelCellStyle->getBorderProps();
        if (count($borderProps) > 0) {
            $styleToApply->getBorders()->applyFromArray($borderProps);
        }

        $alignmentProps = $excelCellStyle->getAlignmentProps();
        if ($alignmentProps) {
            $styleToApply->getAlignment()->applyFromArray($alignmentProps);
        }

        $fillProps = $excelCellStyle->getFillProps();
        if ($fillProps) {
            $styleToApply->getFill()->applyFromArray($fillProps);
        }

        $numberFormatProps = $excelCellStyle->getNumberFormatProps();
        if ($numberFormatProps) {
            $styleToApply->getNumberFormat()->applyFromArray($numberFormatProps);
        }
    }

    public function mergeCells(int $rowStart, int $rowEnd, int $colStart, int $colEnd)
    {
        $this->worksheet->mergeCells([$colStart + 1, $rowStart + 1, $colEnd + 1, $rowEnd + 1]);
    }

    public function setAutoFitColumnWidth(int $col)
    {
        $this->worksheet->getColumnDimensionByColumn($col + 1)->setAutoSize(true);
    }

    public function setColumnWidth(int $col, float $width)
    {
        $this->worksheet->getColumnDimensionByColumn($col + 1)->setWidth($width);
    }

    public function setDefaultColumnWidth(float $width)
    {
        $this->worksheet->getDefaultColumnDimension()->setWidth($width);
    }

    public function setRowHeight(int $row, float $height = -1)
    {
        $this->worksheet->getRowDimension($row + 1)->setRowHeight($height);
    }

    public function setDefaultRowHeight(float $height)
    {
        $this->worksheet->getDefaultRowDimension()->setRowHeight($height);
    }

    public function setTitle(string $title)
    {
        $this->worksheet->setTitle($title);
    }

    public function setPageSetup(ExcelPageSetup $pageSetup)
    {
        $this->worksheet->setPageSetup($pageSetup->getPageSetup());
        $this->worksheet->setPageMargins($pageSetup->getPageMargins());
        $this->worksheet->setHeaderFooter($pageSetup->getHeaderFooter());
        $this->worksheet->setPrintGridlines($pageSetup->getPrintGridLines());
    }

    public static function getCellAddress(int $row, int $col)
    {
        return Coordinate::stringFromColumnIndex($col + 1) . ($row + 1);
    }
}
