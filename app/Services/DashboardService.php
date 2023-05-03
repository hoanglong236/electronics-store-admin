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
            ->whereBetween('orders.created_at', [$fromDate, $toDate])
            ->groupBy('orders.id')
            ->get();
    }

    private function getInitialOrderStatusCount()
    {
        return [
            OrderStatusConstants::RECEIVED => 0,
            OrderStatusConstants::PROCESSING => 0,
            OrderStatusConstants::DELIVERING => 0,
            OrderStatusConstants::COMPLETED => 0,
            OrderStatusConstants::CANCELLED => 0,
        ];
    }

    public function getOrderStatisticData($fromDate, $toDate)
    {
        $orderStatusCount = $this->getInitialOrderStatusCount();
        $customOrders = $this->getCustomOrdersInRange($fromDate, $toDate);

        if (count($customOrders) === 0) {
            return [];
        }

        foreach ($customOrders as $customOrder) {
            $orderStatusCount[$customOrder->status]++;
        }

        $orderStatisticData = [
            'statusCount' => $orderStatusCount,
        ];
        return $orderStatisticData;
    }

    public function getOrderStatisticExportData($fromDate, $toDate)
    {
        $orderStatusCount = $this->getInitialOrderStatusCount();
        $customOrders = $this->getCustomOrdersInRange($fromDate, $toDate);

        foreach ($customOrders as $customOrder) {
            $orderStatusCount[$customOrder->status]++;
        }

        $orderStatisticData = [
            'statusCount' => $orderStatusCount,
            'customOrders' => $customOrders,
        ];
        return $orderStatisticData;
    }

    public function getNewCustomerCount($fromDate, $toDate)
    {
        $result = DB::table('customers')
            ->selectRaw('count(*) as newCustomerCount')
            ->whereBetween('created_at', [$fromDate, $toDate])
            ->first();

        return $result->newCustomerCount;
    }

    public function getPlacedOrderCount($fromDate, $toDate)
    {
        $result = DB::table('orders')
            ->selectRaw('count(*) as placedOrderCount')
            ->whereBetween('orders.created_at', [$fromDate, $toDate])
            ->first();

        return $result->placedOrderCount;
    }

    public function getSoldItemCount($fromDate, $toDate)
    {
        $result = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->selectRaw('IFNULL(sum(order_items.quantity), 0) as soldItemCount')
            ->whereBetween('orders.created_at', [$fromDate, $toDate])
            ->where('orders.status', OrderStatusConstants::COMPLETED)
            ->first();

        return intval($result->soldItemCount);
    }

    private function getBestSellingCategories($fromDate, $toDate, $limit)
    {
        return DB::table('orders')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->select(
                'categories.id',
                'categories.name',
                DB::raw('sum(order_items.quantity) as soldQuantity'),
            )
            ->whereBetween('orders.created_at', [$fromDate, $toDate])
            ->where('orders.status', OrderStatusConstants::COMPLETED)
            ->groupBy('categories.id', 'categories.name')
            ->orderByRaw('soldQuantity desc')
            ->limit($limit)
            ->get();
    }

    private function getBestSellingBrandsFromCategories($fromDate, $toDate, $categories, $limit)
    {
        $brands = [];
        foreach ($categories as $category) {
            $brands[$category->id] = DB::table('orders')
                ->join('order_items', 'order_items.order_id', '=', 'orders.id')
                ->join('products', 'products.id', '=', 'order_items.product_id')
                ->join('brands', 'brands.id', '=', 'products.brand_id')
                ->select(
                    'products.category_id',
                    'brands.id',
                    'brands.name',
                    DB::raw('sum(order_items.quantity) as soldQuantity'),
                )
                ->whereBetween('orders.created_at', [$fromDate, $toDate])
                ->where('orders.status', OrderStatusConstants::COMPLETED)
                ->where('products.category_id', $category->id)
                ->groupBy('products.category_id', 'brands.id', 'brands.name')
                ->orderByRaw('soldQuantity desc')
                ->limit($limit)
                ->get();
        }
        return $brands;
    }

    public function getBestSellingStatisticData($fromDate, $toDate)
    {
        $bestSellingCategories = $this->getBestSellingCategories(
            $fromDate,
            $toDate,
            Constants::BEST_SELLING_CATEGORIES_LIMIT
        );
        $bestSellingBrandsMap = $this->getBestSellingBrandsFromCategories(
            $fromDate,
            $toDate,
            $bestSellingCategories,
            Constants::BEST_SELLING_BRANDS_LIMIT
        );

        return [
            'bestSellingCategories' => $bestSellingCategories,
            'bestSellingBrandsMap' => $bestSellingBrandsMap,
        ];
    }
}
