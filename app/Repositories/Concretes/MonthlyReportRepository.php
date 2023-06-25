<?php

namespace App\Repositories\Concretes;

use App\Common\Constants;
use App\Helpers\DateTimeHelper;
use App\Models\Constants\OrderStatusConstants;
use App\Repositories\IMonthlyReportRepository;
use Illuminate\Support\Facades\DB;

class MonthlyReportRepository implements IMonthlyReportRepository
{
    private function getOrderValueTableQueryBuilder(int $month, int $year)
    {
        $firstDateOfMonth = DateTimeHelper::getFirstDateOfMonth($month, $year);
        $lastDateOfMonth = DateTimeHelper::getLastDateOfMonth($month, $year);

        return DB::table('orders')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->select([
                'orders.id',
                'orders.status',
                'orders.created_at',
                DB::raw('SUM(order_items.total_price) AS value')
            ])
            ->whereBetween('created_at', [
                $firstDateOfMonth, DateTimeHelper::dateToEndOfDate($lastDateOfMonth)
            ])
            ->groupBy('orders.id');
    }

    public function getOrdersSummaryDataInMonth(int $month, int $year)
    {
        $orderValueTableQueryBuilder = $this->getOrderValueTableQueryBuilder($month, $year);
        return DB::table($orderValueTableQueryBuilder, 'ov')
            ->select([
                DB::raw('COUNT(*) as placed'),
                DB::raw('SUM(value) as placed_value'),
                DB::raw('COUNT(CASE WHEN status = "Cancelled" THEN 1 ELSE NULL END) as cancelled'),
                DB::raw('SUM(CASE WHEN status = "Cancelled" THEN value ELSE 0 END) as cancelled_value'),
            ])
            ->first();
    }

    public function getOrdersAnalysisDataByDayOfMonth(int $month, int $year)
    {
        $orderValueTableQueryBuilder = $this->getOrderValueTableQueryBuilder($month, $year);
        $result = DB::table($orderValueTableQueryBuilder, 'ov')
            ->select([
                DB::raw('DAY(created_at) as day'),
                DB::raw('COUNT(*) as placed'),
                DB::raw('SUM(value) as placed_value'),
                DB::raw('COUNT(CASE WHEN status = "Cancelled" THEN 1 ELSE NULL END) as cancelled'),
                DB::raw('SUM(CASE WHEN status = "Cancelled" THEN value ELSE 0 END) as cancelled_value'),
            ])
            ->groupByRaw('day')
            ->orderByRaw('day')
            ->get();

        $resultIndex = 0;
        $resultCount = count($result);
        $lastDayOfMonth = DateTimeHelper::getLastDayOfMonth($month, $year);
        $dataReturn = [];

        for ($day = 1; $day <= $lastDayOfMonth; $day++) {
            $record = (object) [
                'day' => $day,
                'placed' => 0,
                'placed_value' => 0,
                'cancelled' => 0,
                'cancelled_value' => 0
            ];

            if ($resultIndex < $resultCount && $result[$resultIndex]->day === $day) {
                $record = $result[$resultIndex];
                $resultIndex++;
            }

            $dataReturn[] = $record;
        }

        return $dataReturn;
    }

    public function getBestSellerProducts(int $month, int $year)
    {
        $firstDateOfMonth = DateTimeHelper::getFirstDateOfMonth($month, $year);
        $lastDateOfMonth = DateTimeHelper::getLastDateOfMonth($month, $year);

        return DB::table('products')
            ->join('order_items', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->select([
                'products.id',
                'products.name',
                DB::raw('sum(order_items.quantity) as quantity'),
            ])
            ->whereBetween('orders.created_at', [
                $firstDateOfMonth, DateTimeHelper::dateToEndOfDate($lastDateOfMonth)
            ])
            ->where('orders.status', OrderStatusConstants::COMPLETED)
            ->groupBy('products.id')
            ->limit(Constants::BEST_SELLER_PRODUCTS_LIMIT)
            ->get();
    }

    public function getBestSellerCategories(int $month, int $year)
    {
        $firstDateOfMonth = DateTimeHelper::getFirstDateOfMonth($month, $year);
        $lastDateOfMonth = DateTimeHelper::getLastDateOfMonth($month, $year);

        return DB::table('categories')
            ->join('products', 'products.category_id', '=', 'categories.id')
            ->join('order_items', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->select([
                'categories.id',
                'categories.name',
                DB::raw('sum(order_items.quantity) as quantity'),
            ])
            ->whereBetween('orders.created_at', [
                $firstDateOfMonth, DateTimeHelper::dateToEndOfDate($lastDateOfMonth)
            ])
            ->where('orders.status', OrderStatusConstants::COMPLETED)
            ->groupBy('categories.id')
            ->limit(Constants::BEST_SELLER_ITEMS_LIMIT)
            ->get();
    }
    public function getBestSellerBrands(int $month, int $year)
    {
        $firstDateOfMonth = DateTimeHelper::getFirstDateOfMonth($month, $year);
        $lastDateOfMonth = DateTimeHelper::getLastDateOfMonth($month, $year);

        return DB::table('brands')
            ->join('products', 'products.brand_id', '=', 'brands.id')
            ->join('order_items', 'order_items.product_id', '=', 'products.id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->select([
                'brands.id',
                'brands.name',
                DB::raw('sum(order_items.quantity) as quantity'),
            ])
            ->whereBetween('orders.created_at', [
                $firstDateOfMonth, DateTimeHelper::dateToEndOfDate($lastDateOfMonth)
            ])
            ->where('orders.status', OrderStatusConstants::COMPLETED)
            ->groupBy('brands.id')
            ->limit(Constants::BEST_SELLER_ITEMS_LIMIT)
            ->get();
    }
}
