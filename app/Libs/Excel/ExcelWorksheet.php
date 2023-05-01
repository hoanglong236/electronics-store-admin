<?php

namespace App\Libs\Excel;

use App\Libs\Excel\Constants\ExcelCellValueType;
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

    public function setTitle($title)
    {
        $this->worksheet->setTitle($title);
    }
}
