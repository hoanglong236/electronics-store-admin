<?php

namespace App\Services;

use App\Common\Constants;
use App\ModelConstants\OrderStatusConstants;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardService
{
    private function getCustomOrdersInRange($fromDate, $toDate, $resultAsCollection = false)
    {
        $result = DB::table('orders')
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

        return $resultAsCollection ? $result : $result->all();
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

    public function getOrderStatisticsData($fromDate, $toDate)
    {
        $orderStatusCount = $this->getInitialOrderStatusCount();
        $customOrders = $this->getCustomOrdersInRange($fromDate, $toDate);

        if (count($customOrders) === 0) {
            return [];
        }

        foreach ($customOrders as $customOrder) {
            $orderStatusCount[$customOrder->status]++;
        }

        return [
            'statusCount' => $orderStatusCount,
        ];
    }

    public function getOrderStatisticsExportData($fromDate, $toDate)
    {
        $orderStatusCount = $this->getInitialOrderStatusCount();
        $customOrders = $this->getCustomOrdersInRange($fromDate, $toDate);

        foreach ($customOrders as $customOrder) {
            $orderStatusCount[$customOrder->status]++;
        }

        return [
            'statusCount' => $orderStatusCount,
            'customOrders' => $customOrders,
        ];
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
        $result = DB::table('orders')
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
            ->groupBy('categories.id')
            ->orderByRaw('soldQuantity desc')
            ->limit($limit)
            ->get();

        $bestSellingCategories = [];
        foreach ($result as $row) {
            $bestSellingCategories[] = (array) $row;
        }
        return $bestSellingCategories;
    }

    private function getBestSellingBrandsByCategory($fromDate, $toDate, $categoryId, $limit)
    {
        $result = DB::table('orders')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->join('brands', 'brands.id', '=', 'products.brand_id')
            ->select(
                'brands.id',
                'brands.name',
                DB::raw('sum(order_items.quantity) as soldQuantity'),
            )
            ->whereBetween('orders.created_at', [$fromDate, $toDate])
            ->where('orders.status', OrderStatusConstants::COMPLETED)
            ->where('products.category_id', $categoryId)
            ->groupBy('brands.id')
            ->orderByRaw('soldQuantity desc')
            ->limit($limit)
            ->get();

        $bestSellingBrands = [];
        foreach ($result as $row) {
            $bestSellingBrands[] = (array) $row;
        }
        return $bestSellingBrands;
    }

    public function getCatalogStatisticsData($fromDate, $toDate)
    {
        $bestSellingCategories = $this->getBestSellingCategories(
            $fromDate,
            $toDate,
            Constants::BEST_SELLING_CATEGORIES_LIMIT
        );
        for ($i = 0; $i < count($bestSellingCategories); $i++) {
            $bestSellingBrands = $this->getBestSellingBrandsByCategory(
                $fromDate,
                $toDate,
                $bestSellingCategories[$i]['id'],
                Constants::BEST_SELLING_BRANDS_LIMIT
            );
            $bestSellingCategories[$i]['bestSellingBrands'] = $bestSellingBrands;
        }

        return [
            'bestSellingCategories' => $bestSellingCategories,
        ];
    }

    private function getBestSellingProductsByBrandAndCategory($fromDate, $toDate, $categoryId, $brandId, $limit)
    {
        $result = DB::table('orders')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->select(
                'products.id',
                'products.name',
                DB::raw('sum(order_items.quantity) as soldQuantity'),
            )
            ->whereBetween('orders.created_at', [$fromDate, $toDate])
            ->where('orders.status', OrderStatusConstants::COMPLETED)
            ->where('products.category_id', $categoryId)
            ->where('products.brand_id', $brandId)
            ->groupBy('products.id')
            ->orderByRaw('soldQuantity desc')
            ->limit($limit)
            ->get();

        $bestSellingProducts = [];
        foreach ($result as $row) {
            $bestSellingProducts[] = (array) $row;
        }
        return $bestSellingProducts;
    }

    public function getCatalogStatisticsExportData($fromDate, $toDate)
    {
        $bestSellingCategories = $this->getBestSellingCategories(
            $fromDate,
            $toDate,
            Constants::BEST_SELLING_CATEGORIES_LIMIT
        );
        for ($i = 0; $i < count($bestSellingCategories); $i++) {
            $bestSellingBrands = $this->getBestSellingBrandsByCategory(
                $fromDate,
                $toDate,
                $bestSellingCategories[$i]['id'],
                Constants::BEST_SELLING_BRANDS_LIMIT
            );
            for ($j = 0; $j < count($bestSellingBrands); $j++) {
                $bestSellingProducts = $this->getBestSellingProductsByBrandAndCategory(
                    $fromDate,
                    $toDate,
                    $bestSellingCategories[$i]['id'],
                    $bestSellingBrands[$j]['id'],
                    3
                );
                $bestSellingBrands[$j]['bestSellingProducts'] = $bestSellingProducts;
            }
            $bestSellingCategories[$i]['bestSellingBrands'] = $bestSellingBrands;
        }

        return [
            'bestSellingCategories' => $bestSellingCategories,
        ];
    }
}
