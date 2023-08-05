<?php

namespace App\Services\Exports;

abstract class ExportCsvService
{
    protected $props;

    protected abstract function getLabels();
    protected abstract function getRecordIterator();
    protected abstract function convertIteratorElementToArray(object $element);

    private function generateCsv(array $labels, object $iterator)
    {
        $fileName = "filter_orders_" . date('Y-m-d') . ".csv";

        header('Content-Description: File Transfer');
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . rawurlencode($fileName) . '"');
        header('Cache-Control: max-age=604800, must-revalidate');
        header('Pragma: public');

        $stream = fopen('php://output', 'w');

        fputcsv($stream, $labels);
        foreach ($iterator as $element) {
            fputcsv($stream, $this->convertIteratorElementToArray($element));
        }

        fclose($stream);
        exit;
    }

    public function export(array $props)
    {
        $this->props = $props;

        $labels = $this->getLabels();
        $iterator = $this->getRecordIterator();
        $this->generateCsv($labels, $iterator);
    }
}
