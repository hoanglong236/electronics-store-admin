<?php

namespace App\Repositories;

use App\DataFilterConstants\OrderSearchOptionConstants;
use App\Models\Order;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class OrderRepository implements IOrderRepository
{
    public function findById(int $id)
    {
        return Order::find($id)->first();
    }

    private function getCustomOrdersTableQueryBuilder()
    {
        return DB::table('orders')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->select(
                'orders.*',
                'customers.name as customer_name',
                'customers.phone as customer_phone',
                'customers.email as customer_email',
                DB::raw('sum(order_items.total_price) as total'),
            )
            ->groupBy('orders.id');
    }

    public function getCustomOrderById(int $id)
    {
        return DB::table($this->getCustomOrdersTableQueryBuilder(), 'custom_orders')
            ->where(['id' => $id])->first();
    }

    public function update(array $attributes, int $id)
    {
        $order = $this->findById($id);
        if ($order) {
            $order->update($attributes);
            return $order;
        }
        return false;
    }

    public function paginateCustomOrders(int $itemPerPage)
    {
        return DB::table($this->getCustomOrdersTableQueryBuilder(), 'custom_orders')
            ->latest()
            ->paginate($itemPerPage);
    }

    public function searchAndFilterCustomOrdersAndPaginate(
        array $filterColumnMap, string $searchOption, string $escapedKeyword, int $itemPerPage
    ) {
        $queryBuilder = $this->getSearchCustomOrdersQueryBuilder($searchOption, $escapedKeyword);
        if (!$queryBuilder) {
            return new LengthAwarePaginator([], 0, $itemPerPage);
        }

        foreach ($filterColumnMap as $filterColumn) {
            $queryBuilder->where($filterColumn['column'], $filterColumn['value']);
        }

        return $queryBuilder->latest()
            ->paginate($itemPerPage);
    }

    private function getSearchCustomOrdersQueryBuilder(string $searchOption, string $escapedKeyword)
    {
        switch ($searchOption) {
            case OrderSearchOptionConstants::ALL:
                return $this->getSearchCustomOrdersByAllQueryBuilder($escapedKeyword);
            case OrderSearchOptionConstants::CUSTOMER:
                return $this->getSearchCustomOrdersByCustomerQueryBuilder($escapedKeyword);
            case OrderSearchOptionConstants::ADDRESS:
                return $this->getSearchCustomOrdersByAddressQueryBuilder($escapedKeyword);
            default:
                return false;
        }
    }

    private function getSearchCustomOrdersByAllQueryBuilder(string $escapedKeyword)
    {
        return DB::table($this->getCustomOrdersTableQueryBuilder(), 'custom_orders')
            ->where(function ($query) use ($escapedKeyword) {
                $query->where('customer_name', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('customer_email', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('customer_phone', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('delivery_address', 'LIKE', '%' . $escapedKeyword . '%');

                if (is_numeric($escapedKeyword)) {
                    $query->orWhere('id', 'LIKE', '%' . $escapedKeyword . '%');
                }
            });
    }

    private function getSearchCustomOrdersByCustomerQueryBuilder(string $escapedKeyword)
    {
        return DB::table($this->getCustomOrdersTableQueryBuilder(), 'custom_orders')
            ->where(function ($query) use ($escapedKeyword) {
                $query->where('customer_name', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('customer_email', 'LIKE', '%' . $escapedKeyword . '%')
                    ->orWhere('customer_phone', 'LIKE', '%' . $escapedKeyword . '%');
            });
    }

    private function getSearchCustomOrdersByAddressQueryBuilder(string $escapedKeyword)
    {
        return DB::table($this->getCustomOrdersTableQueryBuilder(), 'custom_orders')
            ->where('delivery_address', 'LIKE', '%' . $escapedKeyword . '%');
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
            ->where(['order_items.order_id' => $orderId])
            ->get();
    }
}