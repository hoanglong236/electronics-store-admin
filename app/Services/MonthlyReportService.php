<?php

namespace App\Services;

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

        $data['ordersSummary'] = $this->monthlyReportRepository
            ->getOrdersSummaryDataInMonth($month, $year);
        $data['ordersAnalysis'] = $this->monthlyReportRepository
            ->getOrdersAnalysisDataByDayOfMonth($month, $year);

        $data['bestSellers']['products'] = $this->monthlyReportRepository
            ->getBestSellerProducts($month, $year);
        $data['bestSellers']['brands'] = $this->monthlyReportRepository
            ->getBestSellerBrands($month, $year);
        $data['bestSellers']['categories'] = $this->monthlyReportRepository
            ->getBestSellerCategories($month, $year);

        return $data;
    }
}
