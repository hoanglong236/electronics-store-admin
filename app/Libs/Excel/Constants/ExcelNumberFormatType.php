<?php

namespace App\Libs\Excel\Constants;

use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class ExcelNumberFormatType
{
    const GENERAL = NumberFormat::FORMAT_GENERAL;

    const TEXT = NumberFormat::FORMAT_TEXT;

    const NUMBER = NumberFormat::FORMAT_NUMBER;
    const NUMBER_0 = NumberFormat::FORMAT_NUMBER_0;
    const NUMBER_00 = NumberFormat::FORMAT_NUMBER_00;
    const NUMBER_COMMA_SEPARATED1 = NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1;
    const NUMBER_COMMA_SEPARATED2 = NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED2;

    const PERCENTAGE = NumberFormat::FORMAT_PERCENTAGE;
    const PERCENTAGE_0 = NumberFormat::FORMAT_PERCENTAGE_0;
    const PERCENTAGE_00 = NumberFormat::FORMAT_PERCENTAGE_00;

    const DATE_YYYYMMDD = NumberFormat::FORMAT_DATE_YYYYMMDD;
    const DATE_DDMMYYYY = NumberFormat::FORMAT_DATE_DDMMYYYY;
    const DATE_XLSX22 = NumberFormat::FORMAT_DATE_XLSX22;
    const DATE_DATETIME = NumberFormat::FORMAT_DATE_DATETIME;
    const DATE_TIME1 = NumberFormat::FORMAT_DATE_TIME1;
    const DATE_TIME2 = NumberFormat::FORMAT_DATE_TIME2;
    const DATE_TIME3 = NumberFormat::FORMAT_DATE_TIME3;
    const DATE_TIME4 = NumberFormat::FORMAT_DATE_TIME4;

    const CURRENCY_USD_INTEGER = NumberFormat::FORMAT_CURRENCY_USD_INTEGER;
    const CURRENCY_USD = NumberFormat::FORMAT_CURRENCY_USD;
    const CURRENCY_EUR_INTEGER = NumberFormat::FORMAT_CURRENCY_EUR_INTEGER;
    const CURRENCY_EUR = NumberFormat::FORMAT_CURRENCY_EUR;
    const ACCOUNTING_USD = NumberFormat::FORMAT_ACCOUNTING_USD;
    const ACCOUNTING_EUR = NumberFormat::FORMAT_ACCOUNTING_EUR;
}
