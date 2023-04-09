<?php

namespace App\Services;

use App\DataFilterConstants\OrderPaymentFilterConstants;
use App\DataFilterConstants\OrderSearchOptionConstants;
use App\DataFilterConstants\OrderStatusFilterConstants;
use App\ModelConstants\OrderStatusConstants;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService
{
    public function getCustomOrderById($orderId)
    {
        $queryBuilder = $this->getBaseCustomOrdersQueryBuilder();
        return $queryBuilder->where(['orders.id' => $orderId])
            ->groupBy('orders.id')
            ->first();
    }

    public function listCustomOrderData()
    {
        $queryBuilder = $this->getBaseCustomOrdersQueryBuilder();
        return $queryBuilder->groupBy('orders.id')
            ->orderByDesc('orders.created_at')
            ->get();
    }

    public function updateOrderStatus($orderStatusProperties, $orderId)
    {
        $order = Order::find($orderId);
        $order->status = $orderStatusProperties['status'];

        $order->save();
    }

    public function getNextSelectableStatusMap()
    {
        return [
            OrderStatusConstants::RECEIVED => [OrderStatusConstants::PROCESSING, OrderStatusConstants::CANCELLED],
            OrderStatusConstants::PROCESSING => [OrderStatusConstants::DELIVERING, OrderStatusConstants::CANCELLED],
            OrderStatusConstants::DELIVERING => [OrderStatusConstants::COMPLETED, OrderStatusConstants::CANCELLED],
            OrderStatusConstants::COMPLETED => [],
            OrderStatusConstants::CANCELLED => [],
        ];
    }

    public function searchCustomOrders($orderSearchProperties)
    {
        $searchKeyword = $orderSearchProperties['searchKeyword'];
        $searchOption = $orderSearchProperties['searchOption'];

        return $this->searchAndFilterCustomOrders($searchKeyword, $searchOption);
    }

    public function filterCustomOrders($orderFilterProperties)
    {
        $searchKeyword = $orderFilterProperties['searchKeyword'];
        $escapedKeyword = UtilsService::escapeKeyword($searchKeyword);

        $searchOption = $orderFilterProperties['searchOption'];
        $statusFilter = $orderFilterProperties['statusFilter'];
        $paymentFilter = $orderFilterProperties['paymentFilter'];

        return $this->searchAndFilterCustomOrders($escapedKeyword, $searchOption, $statusFilter, $paymentFilter);
    }

    private function searchAndFilterCustomOrders(
        $escapedKeyword,
        $searchOption,
        $statusFilter = OrderStatusFilterConstants::ALL,
        $paymentFilter = OrderPaymentFilterConstants::ALL
    ) {
        switch ($searchOption) {
            case OrderSearchOptionConstants::ALL:
                return $this->searchCustomOrdersByAll($escapedKeyword, $statusFilter, $paymentFilter);
            case OrderSearchOptionConstants::CUSTOMER:
                return $this->searchCustomOrdersByCustomerInfo($escapedKeyword, $statusFilter, $paymentFilter);
            case OrderSearchOptionConstants::ADDRESS:
                return $this->searchCustomOrdersByDeliveryAddress($escapedKeyword, $statusFilter, $paymentFilter);
            default:
                return [];
        }
    }

    private function searchCustomOrdersByAll($escapedKeyword, $statusFilter, $paymentFilter)
    {
        $queryBuilder = $this->getBaseCustomOrdersQueryBuilder();
        $queryBuilder->where(function ($query) use ($escapedKeyword) {
            $query->where('customers.name', 'LIKE', '%' . $escapedKeyword . '%')
                ->orWhere('customers.email', 'LIKE', '%' . $escapedKeyword . '%')
                ->orWhere('customers.phone', 'LIKE', '%' . $escapedKeyword . '%')
                ->orWhere('orders.delivery_address', 'LIKE', '%' . $escapedKeyword . '%');
        });

        return $this->filterCustomOrdersAfterSearch($queryBuilder, $statusFilter, $paymentFilter);
    }

    private function searchCustomOrdersByCustomerInfo($escapedKeyword, $statusFilter, $paymentFilter)
    {
        $queryBuilder = $this->getBaseCustomOrdersQueryBuilder();
        $queryBuilder->where(function ($query) use ($escapedKeyword) {
            $query->where('customers.name', 'LIKE', '%' . $escapedKeyword . '%')
                ->orWhere('customers.email', 'LIKE', '%' . $escapedKeyword . '%')
                ->orWhere('customers.phone', 'LIKE', '%' . $escapedKeyword . '%');
        });

        return $this->filterCustomOrdersAfterSearch($queryBuilder, $statusFilter, $paymentFilter);
    }

    private function searchCustomOrdersByDeliveryAddress($escapedKeyword, $statusFilter, $paymentFilter)
    {
        $queryBuilder = $this->getBaseCustomOrdersQueryBuilder();
        $queryBuilder->where(function ($query) use ($escapedKeyword) {
            $query->where('orders.delivery_address', 'LIKE', '%' . $escapedKeyword . '%');
        });

        return $this->filterCustomOrdersAfterSearch($queryBuilder, $statusFilter, $paymentFilter);
    }

    private function filterCustomOrdersAfterSearch(
        $searchCustomOrdersQueryBuilder,
        $statusFilter,
        $paymentFilter
    ) {
        if ($statusFilter !== OrderStatusFilterConstants::ALL) {
            $searchCustomOrdersQueryBuilder->where('orders.status', $statusFilter);
        }
        if ($paymentFilter !== OrderPaymentFilterConstants::ALL) {
            $searchCustomOrdersQueryBuilder->where('orders.payment_method', $paymentFilter);
        }

        return $searchCustomOrdersQueryBuilder->groupBy('orders.id')
            ->orderByDesc('orders.created_at')
            ->get();
    }

    /**
     * Must be used in conjunction with the groupBy('orders.id') method
     */
    private function getBaseCustomOrdersQueryBuilder()
    {
        return DB::table('orders')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->select(
                'orders.id',
                'orders.customer_id',
                'orders.delivery_address',
                'orders.address_type',
                'orders.status',
                'orders.payment_method',
                'orders.created_at',
                'orders.updated_at',
                'customers.name as customer_name',
                'customers.phone as customer_phone',
                'customers.email as customer_email',
                DB::raw('sum(order_items.total_price) as total'),
            );
    }
}
