<?php

namespace App\Libs\Excel;

use PhpOffice\PhpSpreadsheet\Cell\Coordinate;

class ExcelUtils
{
    public static function getCellAddress(int $row, int $col)
    {
        return static::getColumnAddress($col) . ($row);
    }

    public static function getColumnAddress(int $col)
    {
        return Coordinate::stringFromColumnIndex($col);
    }
}
