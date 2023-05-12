<?php

namespace App\Libs\Csv;

class SimpleCsvWriter
{
    private $headers;
    private $fileName;
    private $rows;

    public function __construct($fileName)
    {
        $this->fileName = $fileName;
        $this->headers = [
            'Content-Description' => 'File Transfer',
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . rawurlencode($this->fileName) . '"',
            'Cache-Control' => 'max-age=604800, must-revalidate',
            'Expires' => '0',
            'Pragma' => 'public'
        ];
        $this->rows = [];
    }

    public function download()
    {
        $data = $this->rows;
        $callback = function () use ($data) {
            $stream = fopen('php://output', 'w');
            foreach ($data as $row) {
                fputcsv($stream, $row);
            }
            fclose($stream);
        };
        return response()->stream($callback, 200, $this->headers);
    }

    public function addRow(array $row)
    {
        $this->rows[] = $row;
    }
}
