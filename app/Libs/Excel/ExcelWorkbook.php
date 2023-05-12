<?php

namespace App\Libs\Excel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

/**
 * ExcelWorkbook. By default, creating a new instance of ExcelWorkbook will also
 * create the first sheet and make it active.
 * You can get that sheet using getActiveWorksheet() method
 */
class ExcelWorkbook
{
    private $spreadsheet;
    private $fileName;

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
        $this->spreadsheet = new Spreadsheet();
    }

    public function createExcelWorksheet()
    {
        return new ExcelWorksheet($this->spreadsheet->createSheet());
    }

    public function getActiveWorksheet()
    {
        return new ExcelWorksheet($this->spreadsheet->getActiveSheet());
    }

    private function prepareForDownload()
    {
        // Active first sheet
        $this->spreadsheet->setActiveSheetIndex(0);
    }

    public function download()
    {
        $this->prepareForDownload();

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . rawurlencode($this->fileName) . '"');
        header('Cache-Control: max-age=604800, must-revalidate');
        header('Pragma: public');

        $writer = new Xlsx($this->spreadsheet);
        $writer->save('php://output');
    }
}
