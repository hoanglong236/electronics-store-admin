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

        $data['orderPlacedDataset'] = $this->monthlyReportRepository
            ->getOrderPlacedDataset($month, $year);
        $data['numberRegisteredCustomers'] = $this->monthlyReportRepository
            ->getNumberOfRegisteredCustomers($month, $year);
        $data['bestSellerProducts'] = $this->monthlyReportRepository
            ->getBestSellerProducts($month, $year);
        $data['bestSellerBrands'] = $this->monthlyReportRepository
            ->getBestSellerBrands($month, $year);
        $data['bestSellerCategories'] = $this->monthlyReportRepository
            ->getBestSellerCategories($month, $year);

        return $data;
    }
}
