<?php

namespace App\Libs\Excel\Constants;

use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

class ExcelPageSetupConstants
{
    const ORIENTATION_DEFAULT = PageSetup::ORIENTATION_DEFAULT;
    const ORIENTATION_LANDSCAPE = PageSetup::ORIENTATION_LANDSCAPE;
    const ORIENTATION_PORTRAIT = PageSetup::ORIENTATION_PORTRAIT;

    const PAPER_SIZE_LETTER = PageSetup::PAPERSIZE_LETTER;
    const PAPER_SIZE_LETTER_SMALL = PageSetup::PAPERSIZE_LETTER_SMALL;
    const PAPER_SIZE_A3 = PageSetup::PAPERSIZE_A3;
    const PAPER_SIZE_A4 = PageSetup::PAPERSIZE_A4;

    const HEADER_FOOTER_POSITION_LEFT = 'left';
    const HEADER_FOOTER_POSITION_RIGHT = 'right';
    const HEADER_FOOTER_POSITION_CENTER = 'center';

    const PAGE_ORDER_OVER_THEN_DOWN = PageSetup::PAGEORDER_OVER_THEN_DOWN;
    const PAGE_ORDER_DOWN_THEN_OVER = PageSetup::PAGEORDER_DOWN_THEN_OVER;
}
