<?php

namespace App\Services\Exports;

use App\Http\Requests\Constants\OrderFilterRequestConstants;
use App\Repositories\IOrderRepository;
use App\Utils\CommonUtil;

class OrderExportCsvService extends ExportCsvService
{
    private $orderRepository;

    public function __construct(IOrderRepository $iOrderRepository)
    {
        $this->orderRepository = $iOrderRepository;
    }

    protected function getLabels()
    {
        return [
            'ID',
            'Email',
            'Payment Method',
            'Status',
            'Total',
            'Create Date',
        ];
    }

    protected function getRecordIterator()
    {
        $orderFilterProperties = $this->props;

        $searchFields = [];
        $orderIdKeyword = $orderFilterProperties['orderIdKeyword'];
        if ($orderIdKeyword) {
            $searchFields[] = [
                'name' => 'orderId',
                'value' => CommonUtil::escapeKeyword($orderIdKeyword)
            ];
        }
        $emailKeyword = $orderFilterProperties['emailKeyword'];
        if ($emailKeyword) {
            $searchFields[] = [
                'name' => 'email',
                'value' => CommonUtil::escapeKeyword($emailKeyword)
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

    protected function convertIteratorElementToArray(object $element)
    {
        return [
            $element->id,
            $element->email,
            $element->payment_method,
            $element->status,
            $element->total,
            $element->create_date,
        ];
    }
}
