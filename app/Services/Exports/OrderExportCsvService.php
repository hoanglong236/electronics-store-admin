<?php

namespace App\Services\Exports;

use App\Http\Requests\Constants\OrderFilterRequestConstants;
use App\Repositories\IOrderRepository;
use App\Services\UtilsService;
use Illuminate\Support\Facades\Log;

class OrderExportCsvService extends ExportCsvService
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

    protected function getData(array $props)
    {
        $data = [];
        $data['iterator'] = $this->getFilterCustomOrdersIterator($props);
        $data['labels'] = [
            'Order ID',
            'Email',
            'Total',
            'Payment Method',
            'Status',
            'Create Date',
        ];
        return $data;
    }
}
