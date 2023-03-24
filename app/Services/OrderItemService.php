<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderItemService
{
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
