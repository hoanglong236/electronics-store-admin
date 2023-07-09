<?php

namespace App\Repositories;

interface IMonthlyReportRepository
{
    public function getOrderAnalysisDataByDayOfMonth(int $month, int $year);

    public function getBestSellerProducts(int $month, int $year);
    public function getBestSellerCategories(int $month, int $year);
    public function getBestSellerBrands(int $month, int $year);
}
