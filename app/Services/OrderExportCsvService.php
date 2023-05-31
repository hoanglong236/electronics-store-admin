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
        $phoneOrEmailKeyword = $orderFilterProperties['phoneOrEmailKeyword'];
        if ($phoneOrEmailKeyword) {
            $searchFields[] = [
                'name' => 'phoneOrEmail',
                'value' => UtilsService::escapeKeyword($phoneOrEmailKeyword)
            ];
        }
        $deliveryAddressKeyword = $orderFilterProperties['deliveryAddressKeyword'];
        if ($deliveryAddressKeyword) {
            $searchFields[] = [
                'name' => 'deliveryAddress',
                'value' => UtilsService::escapeKeyword($deliveryAddressKeyword)
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

        $sortFields = [];
        $sortField = $orderFilterProperties['sortField'];
        switch ($sortField) {
            case OrderFilterRequestConstants::SORT_BY_CREATED_AT:
                $sortFields[] = ['name' => 'createdAt', 'value' => 'desc'];
                break;
            case OrderFilterRequestConstants::SORT_BY_UPDATED_AT:
                $sortFields[] = ['name' => 'updatedAt', 'value' => 'desc'];
                break;
        }

        return $this->orderRepository->getFilterCustomOrdersIterator($searchFields, $filterFields, $sortFields);
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
            'Phone Number',
            'Delivery Address',
            'Status',
            'Payment Method',
            'Total',
            'Created at',
            'Updated at',
        ];
        fputcsv($stream, $columns);

        foreach ($customOrdersIterator as $customOrder) {
            fputcsv($stream, [
                $customOrder->id,
                $customOrder->customer_email,
                $customOrder->customer_phone,
                $customOrder->delivery_address,
                $customOrder->status,
                $customOrder->payment_method,
                $customOrder->total,
                $customOrder->created_at,
                $customOrder->updated_at,
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
