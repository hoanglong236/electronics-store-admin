<?php

namespace App\Repositories\Concretes;

use App\Utils\DateTimeUtil;
use App\Models\Order;
use App\Repositories\IOrderRepository;
use Illuminate\Support\Facades\DB;

class OrderRepository implements IOrderRepository
{
    public function update(array $attributes, int $id)
    {
        $order = Order::find($id);
        if ($order) {
            $order->update($attributes);
            return $order;
        }
        return false;
    }

    private function getFilterCustomOrdersQueryBuilder(array $conditions)
    {
        $queryBuilder = DB::table('orders')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->select(
                'orders.id',
                'orders.payment_method',
                'orders.status',
                DB::raw('sum(order_items.total_price) as total'),
                'customers.email',
                DB::raw('date(orders.created_at) as create_date'),
            );

        $searchFields = $conditions['searchFields'] ?? [];
        foreach ($searchFields as $searchField) {
            $escapedKeyword = $searchField['value'];
            switch ($searchField['name']) {
                case 'orderId':
                    $queryBuilder->where('orders.id', 'LIKE', '%' . $escapedKeyword . '%');
                    break;
                case 'email':
                    $queryBuilder->where('customers.email', 'LIKE', '%' . $escapedKeyword . '%');
                    break;
            }
        }

        $filterFields = $conditions['filterFields'] ?? [];
        foreach ($filterFields as $filterField) {
            switch ($filterField['name']) {
                case 'status':
                    $queryBuilder->where('orders.status', $filterField['value']);
                    break;
                case 'paymentMethod':
                    $queryBuilder->where('orders.payment_method', $filterField['value']);
                    break;
            }
        }

        $queryBuilder->whereBetween('orders.created_at', [
            $conditions['fromDate'], DateTimeUtil::dateToEndOfDate($conditions['toDate'])
        ]);
        return $queryBuilder->groupBy('orders.id');
    }

    public function filterCustomOrdersAndPaginate(array $conditions, int $itemPerPage)
    {
        return $this->getFilterCustomOrdersQueryBuilder($conditions)
            ->latest('id')
            ->paginate($itemPerPage);
    }

    public function getFilterCustomOrdersIterator(array $conditions)
    {
        return $this->getFilterCustomOrdersQueryBuilder($conditions)
            ->lazyByIdDesc();
    }

    public function getOrderAndCustomerInfoByOrderId(int $orderId)
    {
        return DB::table('orders')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->select(
                'orders.*',
                'customers.name as customer_name',
                'customers.email as customer_email',
                'customers.phone as customer_phone',
            )
            ->where('orders.id', $orderId)
            ->first();
    }

    public function getCustomOrderItemsByOrderId(int $orderId)
    {
        return DB::table('order_items')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->select(
                'order_items.product_id',
                'order_items.quantity',
                'order_items.total_price',
                'products.name as product_name',
                'products.main_image_path as product_image_path',
            )
            ->where('order_items.order_id', $orderId)
            ->get();
    }
}
