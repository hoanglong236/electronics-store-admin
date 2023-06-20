<?php

namespace App\Repositories\Concretes;

use App\Common\Constants;
use App\Helpers\DateTimeHelper;
use App\Models\Constants\OrderStatusConstants;
use App\Models\Customer;
use App\Repositories\IMonthlyReportRepository;
use Illuminate\Support\Facades\DB;

class MonthlyReportRepository implements IMonthlyReportRepository
{
    public function getOrderPlacedDataset(int $month, int $year)
    {
        $firstDateOfMonth = DateTimeHelper::getFirstDateOfMonth($month, $year);
        $lastDateOfMonth = DateTimeHelper::getLastDateOfMonth($month, $year);

        $result = DB::table('orders')
            ->select([
                DB::raw('day(created_at) as `day`'),
                DB::raw('count(*) as `total_placed`'),
                DB::raw('count(case when status = "Cancelled" then 1 else NULL end) as `total_cancelled`'),
            ])
            ->whereBetween('created_at', [
                $firstDateOfMonth, DateTimeHelper::dateToEndOfDate($lastDateOfMonth)
            ])
            ->groupByRaw('day')
            ->orderBy('day')
            ->get();

        $dataset = [];
        $resultIndex = 0;
        $resultCount = count($result);

        for ($day = 1; $day <= DateTimeHelper::getLastDayOfMonth($month, $year); $day++) {
            $totalPlaced = 0;
            $totalCancelled = 0;

            if ($resultIndex < $resultCount && $result[$resultIndex]->day === $day) {
                $totalPlaced = $result[$resultIndex]->total_placed;
                $totalCancelled = $result[$resultIndex]->total_cancelled;
                $resultIndex++;
            }

            $dataset[] = [
                'day' => $day,
                'totalPlaced' => $totalPlaced,
                'totalCancelled' => $totalCancelled
            ];
        }

        return $dataset;
    }

    public function getNumberOfRegisteredCustomers(int $month, int $year)
    {
        $firstDateOfMonth = DateTimeHelper::getFirstDateOfMonth($month, $year);
        $lastDateOfMonth = DateTimeHelper::getLastDateOfMonth($month, $year);

        return Customer::whereBetween('created_at', [
            $firstDateOfMonth, DateTimeHelper::dateToEndOfDate($lastDateOfMonth)
        ])
            ->count();
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
                DB::raw('sum(order_items.quantity) as sold_quantity'),
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
                DB::raw('sum(order_items.quantity) as sold_quantity'),
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
                DB::raw('sum(order_items.quantity) as sold_quantity'),
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
