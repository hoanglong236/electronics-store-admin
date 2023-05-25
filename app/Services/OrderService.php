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

    public function getCustomOrderById($orderId)
    {
        return $this->orderRepository->getCustomOrderById($orderId);
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

    public function getCustomOrderItemsByOrderId($orderId)
    {
        return $this->orderRepository->getCustomOrderItemsByOrderId($orderId);
    }
}
