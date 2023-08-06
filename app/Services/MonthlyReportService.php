<?php

namespace App\Services;

use App\Repositories\IMonthlyReportRepository;

class MonthlyReportService
{
    private $monthlyReportRepository;

    public function __construct(IMonthlyReportRepository $monthlyReportRepository)
    {
        $this->monthlyReportRepository = $monthlyReportRepository;
    }

    public function getMonthlyReportData(int $month, int $year)
    {
        $orderAnalysisData = $this->monthlyReportRepository->getOrderAnalysisDataByDayOfMonth($month, $year);

        $orderPlacedQty = 0;
        $totalOrderValuePlaced = 0;
        $orderCancelledQty = 0;
        $totalOrderValueCancelled = 0;

        foreach ($orderAnalysisData as $item) {
            $orderPlacedQty += $item->placed;
            $totalOrderValuePlaced += $item->placed_value;
            $orderCancelledQty += $item->cancelled;
            $totalOrderValueCancelled += $item->cancelled_value;
        }

        if ($orderPlacedQty === 0) {
            return [];
        }

        $data = [];
        $numberDaysInMonth = count($orderAnalysisData);

        $data['order']['summary'] = [
            'total' => [
                'qty' => [
                    'placed' => $orderPlacedQty,
                    'cancelled' => $orderCancelledQty,
                ],
                'value' => [
                    'placed' => $totalOrderValuePlaced,
                    'cancelled' => $totalOrderValueCancelled,
                ]
            ],
            'avg' => [
                'qtyByDay' => [
                    'placed' => $orderPlacedQty / $numberDaysInMonth,
                    'cancelled' => $orderCancelledQty / $numberDaysInMonth,
                ],
                'totalValueByDay' => [
                    'placed' => $totalOrderValuePlaced / $numberDaysInMonth,
                    'cancelled' => $totalOrderValueCancelled / $numberDaysInMonth,
                ],
                'value' => [
                    'placed' => $totalOrderValuePlaced / $orderPlacedQty,
                    'cancelled' => $totalOrderValueCancelled / $orderCancelledQty,
                ]
            ]
        ];
        $data['order']['analysis'] = $orderAnalysisData;

        $data['bestSellers']['products'] = $this->monthlyReportRepository
            ->getBestSellerProducts($month, $year);
        $data['bestSellers']['brands'] = $this->monthlyReportRepository
            ->getBestSellerBrands($month, $year);
        $data['bestSellers']['categories'] = $this->monthlyReportRepository
            ->getBestSellerCategories($month, $year);

        return $data;
    }
}
