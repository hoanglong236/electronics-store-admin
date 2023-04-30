<?php

namespace App\Libs\Excel\Constants;

use PhpOffice\PhpSpreadsheet\Style\Alignment;

class ExcelTextAlignmentType
{
    const HORIZONTAL_GENERAL = Alignment::HORIZONTAL_GENERAL;
    const HORIZONTAL_LEFT = Alignment::HORIZONTAL_LEFT;
    const HORIZONTAL_RIGHT = Alignment::HORIZONTAL_RIGHT;
    const HORIZONTAL_CENTER = Alignment::HORIZONTAL_CENTER;

    const VERTICAL_BOTTOM = Alignment::VERTICAL_BOTTOM;
    const VERTICAL_TOP = Alignment::VERTICAL_TOP;
    const VERTICAL_CENTER = Alignment::VERTICAL_CENTER;
}
