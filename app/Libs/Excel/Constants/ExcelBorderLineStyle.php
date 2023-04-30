<?php

namespace App\Libs\Excel\Constants;

use PhpOffice\PhpSpreadsheet\Style\Border;

class ExcelBorderLineStyle
{
    const NONE = Border::BORDER_NONE;
    const DASHED = Border::BORDER_DASHED;
    const DOTTED = Border::BORDER_DOTTED;
    const DOUBLE = Border::BORDER_DOUBLE;
    const MEDIUM = Border::BORDER_MEDIUM;
    const THICK = Border::BORDER_THICK;
    const THIN = Border::BORDER_THIN;
}
