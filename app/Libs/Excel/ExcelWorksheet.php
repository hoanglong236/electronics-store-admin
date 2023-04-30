<?php

namespace App\Libs\Excel;

use App\Libs\Excel\Constants\ExcelValueCellType;
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
        string $dataType = ExcelValueCellType::STRING
    ) {
        $this->worksheet->setCellValueExplicit([$col + 1, $row + 1], $value, $dataType);
        return $this;
    }

    public function setCellStyle(
        int $row,
        int $col,
        ExcelCellStyle $style
    ) {
        $cellStyle = $this->worksheet->getStyle([$col + 1, $row + 1]);

        $fontPropsToApply = $style->getFontProps();
        if (count($fontPropsToApply) > 0) {
            $cellStyle->getFont()->applyFromArray($fontPropsToApply);
        }

        $borderPropsToApply = $style->getBorderProps();
        if (count($borderPropsToApply) > 0) {
            $cellStyle->getBorders()->applyFromArray($borderPropsToApply);
        }

        $alignmentPropsToApply = $style->getAlignmentProps();
        if ($alignmentPropsToApply) {
            $cellStyle->getAlignment()->applyFromArray($alignmentPropsToApply);
        }

        return $this;
    }

    public function mergeCells(
        int $rowStart,
        int $rowEnd,
        int $colStart,
        int $colEnd
    ) {
        $this->worksheet->mergeCells([$colStart + 1, $rowStart + 1, $colEnd + 1, $rowEnd + 1]);
    }
}
