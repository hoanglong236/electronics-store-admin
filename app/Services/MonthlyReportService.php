<?php

namespace App\Services;

use App\Helpers\DateTimeHelper;
use App\Repositories\IMonthlyReportRepository;
use Illuminate\Support\Facades\Log;

class MonthlyReportService
{
    private $monthlyReportRepository;

    public function __construct(IMonthlyReportRepository $monthlyReportRepository)
    {
        $this->monthlyReportRepository = $monthlyReportRepository;
    }

    public function getMonthlyReportData(int $month, int $year)
    {
        $data = [];
        $orderSummaryData = $this->monthlyReportRepository->getOrderSummaryDataInMonth($month, $year);
        if ($orderSummaryData->placed === 0) {
            return $data;
        }

        $numberDaysInMonth = DateTimeHelper::getLastDayOfMonth($month, $year);
        $data['order']['summary'] = [
            'all' => [
                'qty' => [
                    'placed' => $orderSummaryData->placed,
                    'cancelled' => $orderSummaryData->cancelled,
                ],
                'value' => [
                    'placed' => $orderSummaryData->placed_value,
                    'cancelled' => $orderSummaryData->cancelled_value,
                ]
            ],
            'avg' => [
                'qty' => [
                    'placed' => $orderSummaryData->placed / $numberDaysInMonth,
                    'cancelled' => $orderSummaryData->cancelled / $numberDaysInMonth,
                ],
                'valueByDay' => [
                    'placed' => $orderSummaryData->placed_value / $numberDaysInMonth,
                    'cancelled' => $orderSummaryData->cancelled_value / $numberDaysInMonth,
                ],
                'valueByQty' => [
                    'placed' => $orderSummaryData->placed_value / $orderSummaryData->placed,
                    'cancelled' => $orderSummaryData->cancelled_value / $orderSummaryData->cancelled,
                ]
            ]
        ];

        $data['order']['analysis'] = $this->monthlyReportRepository
            ->getOrderAnalysisDataByDayOfMonth($month, $year);

        $data['bestSellers']['products'] = $this->monthlyReportRepository
            ->getBestSellerProducts($month, $year);
        $data['bestSellers']['brands'] = $this->monthlyReportRepository
            ->getBestSellerBrands($month, $year);
        $data['bestSellers']['categories'] = $this->monthlyReportRepository
            ->getBestSellerCategories($month, $year);

        return $data;
    }
}
