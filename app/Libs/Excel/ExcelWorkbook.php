<?php

namespace App\Libs\Excel;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExcelWorkbook
{
    private $spreadsheet;
    private $fileName;

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
        $this->spreadsheet = new Spreadsheet();
    }

    public function download()
    {
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="' . urlencode($this->fileName) . '"');
        header('Cache-Control: max-age=0');
        header('Pragma: public');

        $writer = new Xlsx($this->spreadsheet);
        $writer->save('php://output');
    }

    public function createExcelWorksheet()
    {
        return new ExcelWorksheet($this->spreadsheet->createSheet());
    }

    public function getActiveWorksheet()
    {
        return new ExcelWorksheet($this->spreadsheet->getActiveSheet());
    }
}
