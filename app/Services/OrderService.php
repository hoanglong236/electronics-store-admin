<?php

namespace App\Services;

use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderService
{
    public function getCustomOrderById($orderId) {
        return DB::table('orders')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->select(
                'orders.id',
                'orders.customer_id',
                'orders.delivery_address',
                'orders.status',
                'orders.created_at',
                'orders.updated_at',
                'customers.name as customer_name',
                'customers.phone as customer_phone',
                'customers.email as customer_email',
                DB::raw('sum(order_items.total_price) as total'),
            )
            ->where(['orders.id' => $orderId])
            ->groupBy('orders.id')
            ->first();
    }

    public function listCustomOrderData()
    {
        return DB::table('orders')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->select(
                'orders.id',
                'orders.delivery_address',
                'orders.customer_id',
                'orders.status',
                'orders.updated_at',
                'customers.name as customer_name',
                'customers.email as customer_email',
                DB::raw('sum(order_items.total_price) as total'),
            )
            ->groupBy('orders.id')
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
            'Received' => ['Processing', 'Cancelled'],
            'Processing' => ['Delivering', 'Cancelled'],
            'Delivering' => ['Completed', 'Cancelled'],
            'Completed' => [],
            'Cancelled' => [],
        ];
    }
}
