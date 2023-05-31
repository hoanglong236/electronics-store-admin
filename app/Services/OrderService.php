<?php

namespace App\Services;

use App\Common\Constants;
use App\Http\Requests\Constants\OrderFilterRequestConstants;
use App\ModelConstants\OrderStatusConstants;
use App\Repositories\IOrderRepository;
use Illuminate\Support\Facades\Log;

class OrderService
{
    private $orderRepository;

    public function __construct(IOrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function getCustomOrdersPaginator($itemPerPage = Constants::DEFAULT_ITEM_PAGE_COUNT)
    {
        return $this->orderRepository->paginateCustomOrders($itemPerPage);
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

    public function getFilterCustomOrdersPaginator(
        $orderFilterProperties,
        $itemPerPage = Constants::DEFAULT_ITEM_PAGE_COUNT
    ) {
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

        return $this->orderRepository->filterCustomOrdersAndPaginate(
            $searchFields,
            $filterFields,
            $sortFields,
            $itemPerPage
        );
    }

    public function getOrderDetails($orderId)
    {
        $orderDetails = [];

        $customOrder = $this->orderRepository->getCustomOrderById($orderId);
        $orderDetails['order']['id'] = $customOrder->id;
        $orderDetails['order']['status'] = $customOrder->status;
        $orderDetails['order']['paymentMethod'] = $customOrder->payment_method;
        $orderDetails['order']['total'] = $customOrder->total;
        $orderDetails['order']['createdAt'] = $customOrder->created_at;
        $orderDetails['order']['updatedAt'] = $customOrder->updated_at;
        $orderDetails['customer']['id'] = $customOrder->customer_id;
        $orderDetails['customer']['name'] = $customOrder->customer_name;
        $orderDetails['customer']['email'] = $customOrder->customer_email;
        $orderDetails['customer']['phone'] = $customOrder->customer_phone;
        $orderDetails['customer']['deliveryAddress'] = $customOrder->delivery_address;

        $customOrderItems = $this->orderRepository->getCustomOrderItemsByOrderId($orderId);
        foreach ($customOrderItems as $index => $item) {
            $orderDetails['items'][$index]['productId'] = $item->product_id;
            $orderDetails['items'][$index]['productName'] = $item->product_name;
            $orderDetails['items'][$index]['productImagePath'] = $item->product_image_path;
            $orderDetails['items'][$index]['quantity'] = $item->quantity;
            $orderDetails['items'][$index]['totalPrice'] = $item->total_price;
        }

        return $orderDetails;
    }
}
