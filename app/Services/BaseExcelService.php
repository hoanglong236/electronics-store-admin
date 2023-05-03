<?php

namespace App\Services;

use App\Libs\Excel\Constants\ExcelTextAlignmentType;
use App\Libs\Excel\ExcelCellStyle;

class BaseExcelService
{
    protected function generateTableHeaderStyle()
    {
        return (new ExcelCellStyle())->setFontBold()
            ->setBorder()
            ->setHorizontalAlign(ExcelTextAlignmentType::HORIZONTAL_CENTER)
            ->setVerticalAlign(ExcelTextAlignmentType::VERTICAL_CENTER)
            ->setTextWrap()
            ->setFillColor('f8f700');
    }

    protected function generateTableBodyLeftStyle()
    {
        return (new ExcelCellStyle())->setBorder()
            ->setHorizontalAlign(ExcelTextAlignmentType::HORIZONTAL_LEFT)
            ->setVerticalAlign(ExcelTextAlignmentType::VERTICAL_CENTER)
            ->setTextWrap();
    }

    protected function generateTableBodyCenterStyle()
    {
        return (new ExcelCellStyle())->setBorder()
            ->setHorizontalAlign(ExcelTextAlignmentType::HORIZONTAL_CENTER)
            ->setVerticalAlign(ExcelTextAlignmentType::VERTICAL_CENTER)
            ->setTextWrap();
    }

    protected function generateTableBodyRightStyle()
    {
        return (new ExcelCellStyle())->setBorder()
            ->setHorizontalAlign(ExcelTextAlignmentType::HORIZONTAL_RIGHT)
            ->setVerticalAlign(ExcelTextAlignmentType::VERTICAL_CENTER)
            ->setTextWrap();
    }
}
