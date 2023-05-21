<?php

namespace App\Services;

use App\Common\Constants;
use App\DataFilterConstants\OrderPaymentFilterConstants;
use App\DataFilterConstants\OrderStatusFilterConstants;
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
                OrderStatusConstants::PROCESSING,
                OrderStatusConstants::CANCELLED,
            ],
            OrderStatusConstants::PROCESSING => [
                OrderStatusConstants::DELIVERING,
                OrderStatusConstants::CANCELLED,
            ],
            OrderStatusConstants::DELIVERING => [
                OrderStatusConstants::COMPLETED,
                OrderStatusConstants::CANCELLED,
            ],
            OrderStatusConstants::COMPLETED => [],
            OrderStatusConstants::CANCELLED => [],
        ];
    }

    public function getSearchCustomOrdersPaginator(
        $orderSearchProperties,
        $itemPerPage = Constants::DEFAULT_ITEM_PAGE_COUNT
    ) {
        $searchKeyword = $orderSearchProperties['searchKeyword'];
        $searchOption = $orderSearchProperties['searchOption'];
        $escapedKeyword = UtilsService::escapeKeyword($searchKeyword);

        return $this->orderRepository->searchAndFilterCustomOrdersAndPaginate(
            [],
            $searchOption,
            $escapedKeyword,
            $itemPerPage
        );
    }

    public function getFilterCustomOrdersPaginator(
        $orderFilterProperties,
        $itemPerPage = Constants::DEFAULT_ITEM_PAGE_COUNT
    ) {
        $searchKeyword = $orderFilterProperties['searchKeyword'];
        $searchOption = $orderFilterProperties['searchOption'];
        $escapedKeyword = UtilsService::escapeKeyword($searchKeyword);

        $filterColumnMap = [];

        $statusFilter = $orderFilterProperties['statusFilter'];
        if ($statusFilter !== OrderStatusFilterConstants::ALL) {
            $filterColumnMap[] = ['column' => 'status', 'value' => $statusFilter];
        }

        $paymentFilter = $orderFilterProperties['paymentFilter'];
        if ($paymentFilter !== OrderPaymentFilterConstants::ALL) {
            $filterColumnMap[] = ['column' => 'payment_method', 'value' => $paymentFilter];
        }

        return $this->orderRepository->searchAndFilterCustomOrdersAndPaginate(
            $filterColumnMap,
            $searchOption,
            $escapedKeyword,
            $itemPerPage
        );
    }

    public function getCustomOrderItemsByOrderId($orderId)
    {
        return $this->orderRepository->getCustomOrderItemsByOrderId($orderId);
    }
}
