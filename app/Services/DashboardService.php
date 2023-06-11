<?php

namespace App\Services;

use App\Common\Constants;
use App\Models\Constants\OrderStatusConstants;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class DashboardService
{
    public function getOrderStatisticsData($fromDate, $toDate)
    {
        $incompleteOrderCountCaseStatement = "CASE WHEN orders.status IN ('" .
            OrderStatusConstants::RECEIVED . "', '" .
            OrderStatusConstants::PROCESSING . "', '" .
            OrderStatusConstants::DELIVERING . "') THEN 1 ELSE 0 END";
        $completedOrderCountCaseStatement = "CASE WHEN orders.status = '" .
            OrderStatusConstants::COMPLETED . "' THEN 1 ELSE 0 END";
        $cancelledOrderCountCaseStatement = "CASE WHEN orders.status = '" .
            OrderStatusConstants::CANCELLED . "' THEN 1 ELSE 0 END";

        $result = DB::table('orders')
            ->select(
                DB::raw('COALESCE(SUM(' . $incompleteOrderCountCaseStatement . '), 0) as incomplete_count'),
                DB::raw('COALESCE(SUM(' . $completedOrderCountCaseStatement . '), 0) as completed_count'),
                DB::raw('COALESCE(SUM(' . $cancelledOrderCountCaseStatement . '), 0) as cancelled_count')
            )
            ->whereBetween('orders.created_at', [$fromDate, UtilsService::dateToEndOfDate($toDate)])
            ->first();

        $orderStatusCount = [
            'incomplete' => intval($result->incomplete_count),
            'completed' => intval($result->completed_count),
            'cancelled' => intval($result->cancelled_count),
        ];

        return [
            'statusCount' => $orderStatusCount,
        ];
    }

    private function getCustomOrdersInRange($fromDate, $toDate)
    {
        return DB::table('orders')
            ->join('customers', 'customers.id', '=', 'orders.customer_id')
            ->join('order_items', 'order_items.order_id', '=', 'orders.id')
            ->select(
                'orders.id',
                'orders.delivery_address',
                'orders.status',
                'orders.payment_method',
                'orders.created_at',
                'customers.email as customer_email',
                DB::raw('SUM(order_items.total_price) as total'),
            )
            ->whereBetween('orders.created_at', [$fromDate, UtilsService::dateToEndOfDate($toDate)])
            ->groupBy('orders.id')
            ->orderBy('orders.created_at')
            ->get();
    }

    public function getOrderStatisticsExportData($fromDate, $toDate)
    {
        $customOrders = $this->getCustomOrdersInRange($fromDate, $toDate);

        return [
            'customOrders' => $customOrders,
        ];
    }

    public function getNewCustomerCount($fromDate, $toDate)
    {
        $result = DB::table('customers')
            ->selectRaw('COUNT(*) as newCustomerCount')
            ->whereBetween('created_at', [$fromDate, UtilsService::dateToEndOfDate($toDate)])
            ->first();

        return $result->newCustomerCount;
    }

    public function getPlacedOrderCount($fromDate, $toDate)
    {
        $result = DB::table('orders')
            ->selectRaw('COUNT(*) as placedOrderCount')
            ->whereBetween('orders.created_at', [$fromDate, UtilsService::dateToEndOfDate($toDate)])
            ->first();

        return $result->placedOrderCount;
    }

    public function getSoldItemCount($fromDate, $toDate)
    {
        $result = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->selectRaw('COALESCE(SUM(order_items.quantity), 0) as soldItemCount')
            ->whereBetween('orders.created_at', [$fromDate, UtilsService::dateToEndOfDate($toDate)])
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
                DB::raw('SUM(order_items.quantity) as soldQuantity'),
            )
            ->whereBetween('orders.created_at', [$fromDate, UtilsService::dateToEndOfDate($toDate)])
            ->where('orders.status', OrderStatusConstants::COMPLETED)
            ->groupBy('categories.id')
            ->orderByDesc('soldQuantity')
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
                DB::raw('SUM(order_items.quantity) as soldQuantity'),
            )
            ->whereBetween('orders.created_at', [$fromDate, UtilsService::dateToEndOfDate($toDate)])
            ->where('orders.status', OrderStatusConstants::COMPLETED)
            ->where('products.category_id', $categoryId)
            ->groupBy('brands.id')
            ->orderByDesc('soldQuantity')
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
                DB::raw('SUM(order_items.quantity) as soldQuantity'),
            )
            ->whereBetween('orders.created_at', [$fromDate, UtilsService::dateToEndOfDate($toDate)])
            ->where('orders.status', OrderStatusConstants::COMPLETED)
            ->where('products.category_id', $categoryId)
            ->where('products.brand_id', $brandId)
            ->groupBy('products.id')
            ->orderByDesc('soldQuantity')
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
