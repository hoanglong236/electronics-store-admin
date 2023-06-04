<?php

namespace App\Repositories;

use App\Models\Order;
use App\Services\UtilsService;
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
                'orders.id',
                'orders.status',
                'orders.payment_method',
                DB::raw('date(orders.created_at) as create_date'),
                'customers.email as customer_email',
                DB::raw('sum(order_items.total_price) as total'),
            )
            ->groupBy('orders.id');
    }

    private function getCustomOrdersTableQueryBuilder()
    {
        $queryBuilder = $this->getCustomOrdersQueryBuilder();
        return DB::table($queryBuilder, 'custom_orders');
    }

    public function getCustomOrderById(int $id)
    {
        return $this->getCustomOrdersTableQueryBuilder()
            ->where(['id' => $id])
            ->first();
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
            ->latest('id')
            ->paginate($itemPerPage);
    }

    private function getFilterCustomOrdersQueryBuilder(
        array $searchFields, array $filterFields, string $fromDate, string $toDate
    ) {
        $queryBuilder = $this->getCustomOrdersTableQueryBuilder();

        foreach ($searchFields as $searchField) {
            $escapedKeyword = $searchField['value'];
            switch ($searchField['name']) {
                case 'orderId':
                    $queryBuilder->where('id', 'LIKE', '%' . $escapedKeyword . '%');
                    break;
                case 'email':
                    $queryBuilder->where('customer_email', 'LIKE', '%' . $escapedKeyword . '%');
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

        $queryBuilder->whereBetween('create_date', [$fromDate, UtilsService::dateToEndOfDate($toDate)]);
        return $queryBuilder;
    }

    public function filterCustomOrdersAndPaginate(
        array $searchFields, array $filterFields, string $fromDate, string $toDate, int $itemPerPage
    ) {
        return $this->getFilterCustomOrdersQueryBuilder($searchFields, $filterFields, $fromDate, $toDate)
            ->latest('id')
            ->paginate($itemPerPage);
    }

    public function getFilterCustomOrdersIterator(
        array $searchFields, array $filterFields, string $fromDate, string $toDate
    ) {
        return $this->getFilterCustomOrdersQueryBuilder($searchFields, $filterFields, $fromDate, $toDate)
            ->latest('id')
            ->lazyById();
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
