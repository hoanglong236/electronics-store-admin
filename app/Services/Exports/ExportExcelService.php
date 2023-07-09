<?php

namespace App\Services\Exports;

use App\Libs\Excel\Constants\ExcelNumberFormatType;
use App\Libs\Excel\Constants\ExcelTextAlignType;
use App\Libs\Excel\ExcelCellStyle;

abstract class ExportExcelService
{
    protected function generateTableHeaderStyle()
    {
        return (new ExcelCellStyle())->setFontBold()
            ->setBorder()
            ->setHorizontalAlign(ExcelTextAlignType::HORIZONTAL_CENTER)
            ->setVerticalAlign(ExcelTextAlignType::VERTICAL_CENTER)
            ->setTextWrap()
            ->setFillColor('f8f700');
    }

    protected function generateTableBodyLeftStyle()
    {
        return (new ExcelCellStyle())->setBorder()
            ->setHorizontalAlign(ExcelTextAlignType::HORIZONTAL_LEFT)
            ->setVerticalAlign(ExcelTextAlignType::VERTICAL_CENTER)
            ->setTextWrap();
    }

    protected function generateTableBodyBoldLeftStyle()
    {
        return $this->generateTableBodyLeftStyle()
            ->setFontBold();
    }

    protected function generateTableBodyCenterStyle()
    {
        return (new ExcelCellStyle())->setBorder()
            ->setHorizontalAlign(ExcelTextAlignType::HORIZONTAL_CENTER)
            ->setVerticalAlign(ExcelTextAlignType::VERTICAL_CENTER)
            ->setTextWrap();
    }

    protected function generateTableBodyBoldCenterStyle()
    {
        return $this->generateTableBodyCenterStyle()
            ->setFontBold();
    }

    protected function generateTableBodyRightStyle()
    {
        return (new ExcelCellStyle())->setBorder()
            ->setHorizontalAlign(ExcelTextAlignType::HORIZONTAL_RIGHT)
            ->setVerticalAlign(ExcelTextAlignType::VERTICAL_CENTER)
            ->setTextWrap();
    }

    protected function generateTableBodyBoldRightStyle()
    {
        return $this->generateTableBodyRightStyle()
            ->setFontBold();
    }

    protected function generateTableBodyCurrencyStyle()
    {
        return (new ExcelCellStyle())->setBorder()
            ->setHorizontalAlign(ExcelTextAlignType::HORIZONTAL_RIGHT)
            ->setVerticalAlign(ExcelTextAlignType::VERTICAL_CENTER)
            ->setNumberFormat(ExcelNumberFormatType::CURRENCY_USD);
    }

    protected function generateTableBodyBoldCurrencyStyle()
    {
        return $this->generateTableBodyCurrencyStyle()
            ->setFontBold();
    }

    protected abstract function getData(array $props);
    protected abstract function generateExcel(array $data);

    public function export(array $props) {
        $data = $this->getData($props);
        $this->generateExcel($data);
    }
}
