<?php

namespace App\Services;

use App\Constants\ConfigConstants;
use App\Http\Requests\Constants\OrderFilterRequestConstants;
use App\Models\Constants\OrderStatusConstants;
use App\Repositories\IOrderRepository;
use App\Utils\CommonUtil;

class OrderService
{
    private $orderRepository;

    public function __construct(IOrderRepository $iOrderRepository)
    {
        $this->orderRepository = $iOrderRepository;
    }

    public function getCustomOrdersPaginator(
        string $fromDate,
        string $toDate,
        int $itemPerPage = ConfigConstants::DEFAULT_ITEM_PAGE_COUNT
    ) {
        $conditions = [];
        $conditions['fromDate'] = $fromDate;
        $conditions['toDate'] = $toDate;
        return $this->orderRepository->filterCustomOrdersAndPaginate($conditions, $itemPerPage);
    }

    public function getFilterCustomOrdersPaginator(
        array $orderFilterProps, int $itemPerPage = ConfigConstants::DEFAULT_ITEM_PAGE_COUNT
    ) {
        $conditions = [];

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
        return $this->orderRepository->filterCustomOrdersAndPaginate($conditions, $itemPerPage);
    }

    public function updateOrderStatus(array $orderStatusProps, int $orderId)
    {
        $updateAttributes = [];
        $updateAttributes['status'] = $orderStatusProps['status'];
        $this->orderRepository->update($updateAttributes, $orderId);
    }

    public function getNextSelectableStatusMap()
    {
        return [
            OrderStatusConstants::RECEIVED => [
                OrderStatusConstants::PROCESSING, OrderStatusConstants::CANCELLED
            ],
            OrderStatusConstants::PROCESSING => [
                OrderStatusConstants::DELIVERING, OrderStatusConstants::CANCELLED
            ],
            OrderStatusConstants::DELIVERING => [
                OrderStatusConstants::COMPLETED, OrderStatusConstants::CANCELLED
            ],
            OrderStatusConstants::COMPLETED => [],
            OrderStatusConstants::CANCELLED => [],
        ];
    }

    public function getOrderDetails(int $orderId)
    {
        $orderDetails = [];

        $customOrderItems = $this->orderRepository->getCustomOrderItemsByOrderId($orderId);
        foreach ($customOrderItems as $item) {
            $orderDetails['items'][] = [
                'productId' => $item->product_id,
                'productName' => $item->product_name,
                'productImagePath' => $item->product_image_path,
                'quantity' => $item->quantity,
                'totalPrice' => $item->total_price,
            ];
        }

        $customOrder = $this->orderRepository->getOrderAndCustomerInfoByOrderId($orderId);
        $orderDetails['order'] = [
            'id' => $customOrder->id,
            'status' => $customOrder->status,
            'paymentMethod' => $customOrder->payment_method,
            'createdAt' => $customOrder->created_at,
            'updatedAt' => $customOrder->updated_at,
        ];
        $orderDetails['customer'] = [
            'id' => $customOrder->customer_id,
            'name' => $customOrder->customer_name,
            'email' => $customOrder->customer_email,
            'phone' => $customOrder->customer_phone,
            'deliveryAddress' => $customOrder->delivery_address,
        ];

        return $orderDetails;
    }
}
