<?php

namespace App\Services;

use App\Constants\ConfigConstants;
use App\Http\Requests\Constants\OrderFilterRequestConstants;
use App\Models\Constants\OrderStatusConstants;
use App\Repositories\IOrderRepository;
use App\Utils\CommonUtil;
use Illuminate\Support\Facades\Log;

class OrderService
{
    private $orderRepository;

    public function __construct(IOrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getCustomOrdersPaginator(
        $fromDate,
        $toDate,
        $itemPerPage = ConfigConstants::DEFAULT_ITEM_PAGE_COUNT
    ) {
        return $this->orderRepository->filterCustomOrdersAndPaginate(
            [],
            [],
            $fromDate,
            $toDate,
            $itemPerPage
        );
    }

    public function getFilterCustomOrdersPaginator(
        $orderFilterProperties,
        $itemPerPage = ConfigConstants::DEFAULT_ITEM_PAGE_COUNT
    ) {
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

        return $this->orderRepository->filterCustomOrdersAndPaginate(
            $searchFields,
            $filterFields,
            $orderFilterProperties['fromDate'],
            $orderFilterProperties['toDate'],
            $itemPerPage
        );
    }

    public function updateOrderStatus($orderStatusProperties, $orderId)
    {
        $updateAttributes = [];
        $updateAttributes['status'] = $orderStatusProperties['status'];
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

    public function getOrderDetails($orderId)
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

        $customOrder = $this->orderRepository->getOrderAlongWithCustomerInfoById($orderId);
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
