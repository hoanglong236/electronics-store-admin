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
        return $this;
    }

    public function setCellStyle(int $row, int $col, ExcelCellStyle $excelCellStyle)
    {
        $styleToApply = $this->worksheet->getStyle([$col + 1, $row + 1]);
        $this->applyStyleFromExcelCellStyle($styleToApply, $excelCellStyle);

        return $this;
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

        return $this;
    }

    private function applyStyleFromExcelCellStyle(Style &$styleToApply, ExcelCellStyle $excelCellStyle)
    {
        $fontPropsToApply = $excelCellStyle->getFontProps();
        if (count($fontPropsToApply) > 0) {
            $styleToApply->getFont()->applyFromArray($fontPropsToApply);
        }

        $borderPropsToApply = $excelCellStyle->getBorderProps();
        if (count($borderPropsToApply) > 0) {
            $styleToApply->getBorders()->applyFromArray($borderPropsToApply);
        }

        $alignmentPropsToApply = $excelCellStyle->getAlignmentProps();
        if ($alignmentPropsToApply) {
            $styleToApply->getAlignment()->applyFromArray($alignmentPropsToApply);
        }

        $fillPropsToApply = $excelCellStyle->getFillProps();
        if ($fillPropsToApply) {
            $styleToApply->getFill()->applyFromArray($fillPropsToApply);
        }
    }

    public function mergeCells(int $rowStart, int $rowEnd, int $colStart, int $colEnd)
    {
        $this->worksheet->mergeCells([$colStart + 1, $rowStart + 1, $colEnd + 1, $rowEnd + 1]);
    }
}
