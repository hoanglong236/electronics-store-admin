<?php

namespace App\Repositories;

use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderRepository implements IOrderRepository
{
    public function findById(int $id)
    {
        return Order::find($id)->first();
    }

    private function getCustomOrdersQueryBuilder()
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

    private function getCustomOrdersTableQueryBuilder()
    {
        $queryBuilder = $this->getCustomOrdersQueryBuilder()
            ->orderByDesc('orders.created_at');

        return DB::table($queryBuilder, 'custom_orders');
    }

    public function getCustomOrderById(int $id)
    {
        return $this->getCustomOrdersTableQueryBuilder()
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
        return $this->getCustomOrdersTableQueryBuilder()
            ->paginate($itemPerPage);
    }

    public function filterCustomOrdersAndPaginate(
        array $searchFields, array $filterFields, array $sortFields, int $itemPerPage
    ) {
        // executing the 'order by' statement first in the sub query can help speed up query execution
        $customOrdersQueryBuilder = $this->getCustomOrdersQueryBuilder();
        foreach ($sortFields as $sortField) {
            if ($sortField['value'] === 'desc' || $sortField['value'] === 'asc') {
                switch ($sortField['name']) {
                    case 'createdAt':
                        $customOrdersQueryBuilder->orderBy('orders.created_at', $sortField['value']);
                        break;
                    case 'updatedAt':
                        $customOrdersQueryBuilder->orderBy('orders.updated_at', $sortField['value']);
                        break;
                }
            }
        }

        $queryBuilder = DB::table($customOrdersQueryBuilder, 'custom_orders');

        foreach ($searchFields as $searchField) {
            $escapedKeyword = $searchField['value'];
            switch ($searchField['name']) {
                case 'orderId':
                    $queryBuilder->where('id', 'LIKE', '%' . $escapedKeyword . '%');
                    break;
                case 'phoneOrEmail':
                    $queryBuilder->where(function ($query) use ($escapedKeyword) {
                        $query->where('customer_phone', 'LIKE', '%' . $escapedKeyword . '%')
                            ->orWhere('customer_email', 'LIKE', '%' . $escapedKeyword . '%');
                    });
                    break;
                case 'deliveryAddress':
                    $queryBuilder->where('delivery_address', 'LIKE', '%' . $escapedKeyword . '%');
                    break;
            }
        }

        foreach ($filterFields as $filterField) {
            switch ($filterField['name']) {
                case 'status':
                    $queryBuilder->where('status', $filterField['value']);
                    break;
                case 'paymentMethod':
                    $queryBuilder->where('payment_method', $filterField['value']);
                    break;
            }
        }

        return $queryBuilder->paginate($itemPerPage);
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
