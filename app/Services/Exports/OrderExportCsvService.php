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
        $conditions = [];
        $orderFilterProps = $this->props;

        $orderIdKeyword = $orderFilterProps['orderIdKeyword'];
        if ($orderIdKeyword) {
            $conditions['searchFields'][] = [
                'name' => 'orderId',
                'value' => CommonUtil::escapeKeyword($orderIdKeyword)
            ];
        }
        $emailKeyword = $orderFilterProps['emailKeyword'];
        if ($emailKeyword) {
            $conditions['searchFields'][] = [
                'name' => 'email',
                'value' => CommonUtil::escapeKeyword($emailKeyword)
            ];
        }

        $statusFilter = $orderFilterProps['statusFilter'];
        if ($statusFilter !== OrderFilterRequestConstants::ALL) {
            $conditions['filterFields'][] = ['name' => 'status', 'value' => $statusFilter];
        }
        $paymentMethodFilter = $orderFilterProps['paymentMethodFilter'];
        if ($paymentMethodFilter !== OrderFilterRequestConstants::ALL) {
            $conditions['filterFields'][] = ['name' => 'paymentMethod', 'value' => $paymentMethodFilter];
        }

        $conditions['fromDate'] = $orderFilterProps['fromDate'];
        $conditions['toDate'] = $orderFilterProps['toDate'];
        return $this->orderRepository->getFilterCustomOrdersIterator($conditions);
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
