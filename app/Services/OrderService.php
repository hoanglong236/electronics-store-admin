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

    public function listCustomOrders()
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

    public function searchCustomOrders($orderSearchProperties)
    {
        $searchKeyword = $orderSearchProperties['searchKeyword'];
        $searchOption = $orderSearchProperties['searchOption'];
        $escapedKeyword = UtilsService::escapeKeyword($searchKeyword);

        $queryBuilder = $this->getSearchCustomOrdersQueryBuilder($escapedKeyword, $searchOption);
        if (is_null($queryBuilder)) {
            return [];
        }

        return $queryBuilder
            ->groupBy('orders.id')
            ->orderByDesc('orders.created_at')
            ->get();
    }

    public function filterCustomOrders($orderFilterProperties)
    {
        $searchKeyword = $orderFilterProperties['searchKeyword'];
        $searchOption = $orderFilterProperties['searchOption'];
        $escapedKeyword = UtilsService::escapeKeyword($searchKeyword);

        $queryBuilder = $this->getSearchCustomOrdersQueryBuilder($escapedKeyword, $searchOption);
        if (is_null($queryBuilder)) {
            return [];
        }

        $statusFilter = $orderFilterProperties['statusFilter'];
        if ($statusFilter !== OrderStatusFilterConstants::ALL) {
            $queryBuilder->where('orders.status', $statusFilter);
        }

        $paymentFilter = $orderFilterProperties['paymentFilter'];
        if ($paymentFilter !== OrderPaymentFilterConstants::ALL) {
            $queryBuilder->where('orders.payment_method', $paymentFilter);
        }

        return $queryBuilder
            ->groupBy('orders.id')
            ->orderByDesc('orders.created_at')
            ->get();
    }

    private function getSearchCustomOrdersQueryBuilder($escapedKeyword, $searchOption)
    {
        switch ($searchOption) {
            case OrderSearchOptionConstants::ALL:
                return $this->getSearchCustomOrdersByAllQueryBuilder($escapedKeyword);
            case OrderSearchOptionConstants::CUSTOMER:
                return $this->getSearchCustomOrdersByCustomerInfoQueryBuilder($escapedKeyword);
            case OrderSearchOptionConstants::ADDRESS:
                return $this->getSearchCustomOrdersByDeliveryAddressQueryBuilder($escapedKeyword);
            default:
                return null;
        }
    }

    private function getSearchCustomOrdersByAllQueryBuilder($escapedKeyword)
    {
        $queryBuilder = $this->getBaseCustomOrdersQueryBuilder();
        $queryBuilder->where(function ($query) use ($escapedKeyword) {
            $query->where('customers.name', 'LIKE', '%' . $escapedKeyword . '%')
                ->orWhere('customers.email', 'LIKE', '%' . $escapedKeyword . '%')
                ->orWhere('customers.phone', 'LIKE', '%' . $escapedKeyword . '%')
                ->orWhere('orders.delivery_address', 'LIKE', '%' . $escapedKeyword . '%');
        });

        return $queryBuilder;
    }

    private function getSearchCustomOrdersByCustomerInfoQueryBuilder($escapedKeyword)
    {
        $queryBuilder = $this->getBaseCustomOrdersQueryBuilder();
        $queryBuilder->where(function ($query) use ($escapedKeyword) {
            $query->where('customers.name', 'LIKE', '%' . $escapedKeyword . '%')
                ->orWhere('customers.email', 'LIKE', '%' . $escapedKeyword . '%')
                ->orWhere('customers.phone', 'LIKE', '%' . $escapedKeyword . '%');
        });

        return $queryBuilder;
    }

    private function getSearchCustomOrdersByDeliveryAddressQueryBuilder($escapedKeyword)
    {
        $queryBuilder = $this->getBaseCustomOrdersQueryBuilder();
        $queryBuilder->where(function ($query) use ($escapedKeyword) {
            $query->where('orders.delivery_address', 'LIKE', '%' . $escapedKeyword . '%');
        });

        return $queryBuilder;
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

    public function getCustomOrderItemsByOrderId($orderId)
    {
        return DB::table('order_items')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->select(
                'products.name as product_name',
                'products.main_image_path as product_image_path',
                'order_items.product_id',
                'order_items.quantity',
                'order_items.total_price',
            )
            ->where(['order_items.order_id' => $orderId])
            ->get();
    }
}
