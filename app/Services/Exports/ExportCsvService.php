<?php

namespace App\Services\Exports;

abstract class ExportCsvService
{
    protected abstract function getData(array $props);

    private function generateCsv(array $data) {
        $fileName = "filter_orders_" . date('Y-m-d') . ".csv";

        header('Content-Description: File Transfer');
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . rawurlencode($fileName) . '"');
        header('Cache-Control: max-age=604800, must-revalidate');
        header('Pragma: public');

        $stream = fopen('php://output', 'w');

        fputcsv($stream, $data['labels']);
        $iterator = $data['iterator'];

        foreach ($iterator as $obj) {
            fputcsv($stream, array_values((array) $obj));
        }

        fclose($stream);
        exit;
    }

    public function export(array $props) {
        $data = $this->getData($props);
        $this->generateCsv($data);
    }
}
