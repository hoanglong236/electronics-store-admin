<?php

namespace App\Services;

use App\Http\Requests\Constants\OrderFilterRequestConstants;
use App\Repositories\IOrderRepository;
use Illuminate\Support\Facades\Log;

class OrderExportCsvService
{
    private $orderRepository;

    public function __construct(IOrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    private function getFilterCustomOrdersIterator($orderFilterProperties)
    {
        $searchFields = [];
        $orderIdKeyword = $orderFilterProperties['orderIdKeyword'];
        if ($orderIdKeyword) {
            $searchFields[] = [
                'name' => 'orderId',
                'value' => UtilsService::escapeKeyword($orderIdKeyword)
            ];
        }
        $emailKeyword = $orderFilterProperties['emailKeyword'];
        if ($emailKeyword) {
            $searchFields[] = [
                'name' => 'email',
                'value' => UtilsService::escapeKeyword($emailKeyword)
            ];
        }

        $filterFields = [];
        $statusFilter = $orderFilterProperties['statusFilter'];
        if ($statusFilter !== OrderFilterRequestConstants::ALL) {
            $filterFields[] = ['name' => 'status', 'value' => $statusFilter];
        }
        $paymentMethodFilter = $orderFilterProperties['paymentMethodFilter'];
        if ($paymentMethodFilter !== OrderFilterRequestConstants::ALL) {
            $filterFields[] = ['name' => 'paymentMethod', 'value' => $paymentMethodFilter];
        }

        return $this->orderRepository->getFilterCustomOrdersIterator(
            $searchFields,
            $filterFields,
            $orderFilterProperties['fromDate'],
            $orderFilterProperties['toDate']
        );
    }

    private function exportCsv($customOrdersIterator)
    {
        ob_start();

        $currentDate = date('Y-m-d');
        $fileName = "filter_orders_{$currentDate}.csv";

        header('Content-Description: File Transfer');
        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename="' . rawurlencode($fileName) . '"');
        header('Cache-Control: max-age=604800, must-revalidate');
        header('Pragma: public');

        ob_end_clean();
        $stream = fopen('php://output', 'w');

        $columns = [
            'Order ID',
            'Email',
            'Total',
            'Payment Method',
            'Status',
            'Create Date',
        ];
        fputcsv($stream, $columns);

        foreach ($customOrdersIterator as $customOrder) {
            fputcsv($stream, [
                $customOrder->id,
                $customOrder->customer_email,
                $customOrder->total,
                $customOrder->payment_method,
                $customOrder->status,
                $customOrder->create_date,
            ]);
        }

        fclose($stream);
        exit;
    }

    public function filterAndExportCsv($orderFilterProperties)
    {
        $customOrdersIterator = $this->getFilterCustomOrdersIterator($orderFilterProperties);
        $this->exportCsv($customOrdersIterator);
    }
}
