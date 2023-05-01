<?php

namespace App\Libs\Excel\Constants;

use PhpOffice\PhpSpreadsheet\Style\Border;

class ExcelBorderConstants
{
    const LINE_STYLE_NONE = Border::BORDER_NONE;
    const LINE_STYLE_DASHED = Border::BORDER_DASHED;
    const LINE_STYLE_DOTTED = Border::BORDER_DOTTED;
    const LINE_STYLE_DOUBLE = Border::BORDER_DOUBLE;
    const LINE_STYLE_MEDIUM = Border::BORDER_MEDIUM;
    const LINE_STYLE_THICK = Border::BORDER_THICK;
    const LINE_STYLE_THIN = Border::BORDER_THIN;

    const POSITION_ALL = 'allBorders';
    const POSITION_LEFT = 'left';
    const POSITION_RIGHT = 'right';
    const POSITION_TOP = 'top';
    const POSITION_BOTTOM = 'bottom';
}
