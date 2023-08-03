<?php

namespace App\Repositories\Concretes;

use App\Helpers\DateTimeHelper;
use App\Models\Customer;
use App\Models\Product;
use App\Repositories\IDashboardRepository;
use Illuminate\Support\Facades\DB;

class DashboardRepository implements IDashboardRepository
{
    public function getNumberNewCustomers(string $date)
    {
        return Customer::whereBetween('created_at', [$date, DateTimeHelper::dateToEndOfDate($date)])
            ->count();
    }

    public function getRevenue(string $date)
    {
        $queryResult = DB::table('orders')
            ->select([
                DB::raw('SUM(order_items.total_price) as revenue'),
            ])
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->whereBetween('orders.created_at', [$date, DateTimeHelper::dateToEndOfDate($date)])
            ->groupBy('orders.id')
            ->first();

        return $queryResult ? $queryResult->revenue : 0;
    }

    public function getOrderQtyByPaymentMethods(string $date, array $paymentMethods)
    {
        return DB::table('orders')
            ->select([
                'payment_method',
                DB::raw('COUNT(*) AS qty')
            ])
            ->whereIn('payment_method', $paymentMethods)
            ->whereBetween('orders.created_at', [$date, DateTimeHelper::dateToEndOfDate($date)])
            ->groupBy('payment_method')
            ->get();
    }
}
