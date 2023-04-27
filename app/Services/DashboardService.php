<?php

namespace App\Services;

use App\Common\Constants;
use App\ModelConstants\OrderStatusConstants;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardService
{
    private function getCustomOrdersInRange($fromDate, $toDate)
    {
        return DB::table('orders')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->select(
                'orders.id',
                'orders.customer_id',
                'orders.delivery_address',
                'orders.status',
                'orders.payment_method',
                'orders.created_at',
                'orders.updated_at',
                'customers.name as customer_name',
                'customers.phone as customer_phone',
                'customers.email as customer_email',
                DB::raw('sum(order_items.total_price) as total'),
            )
            ->groupBy('orders.id')
            ->get();
    }

    private function getInitialOrderStatusCount()
    {
        return [
            Constants::ORDER_STATUS_COMPLETED => 0,
            Constants::ORDER_STATUS_CANCELLED => 0,
            Constants::ORDER_STATUS_INCOMPLETE => 0,
        ];
    }

    public function getOrderStatisticData($fromDate, $toDate)
    {
        $orderStatusCount = $this->getInitialOrderStatusCount();
        $totalEarning = 0;
        $customOrders = $this->getCustomOrdersInRange($fromDate, $toDate);

        foreach ($customOrders as $customOrder) {
            switch ($customOrder->status) {
                case OrderStatusConstants::COMPLETED:
                    $orderStatusCount[Constants::ORDER_STATUS_COMPLETED]++;
                    $totalEarning += $customOrder->total;
                    break;
                case OrderStatusConstants::CANCELLED:
                    $orderStatusCount[Constants::ORDER_STATUS_CANCELLED]++;
                    break;
                default:
                    $orderStatusCount[Constants::ORDER_STATUS_INCOMPLETE]++;
            }
        }

        $orderStatisticData = [
            'statusCount' => $orderStatusCount,
            'totalEarning' => $totalEarning,
        ];
        return $orderStatisticData;
    }
}
