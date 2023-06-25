<?php

namespace App\Repositories;

interface IMonthlyReportRepository
{
    public function getOrdersSummaryDataInMonth(int $month, int $year);
    public function getOrdersAnalysisDataByDayOfMonth(int $month, int $year);

    public function getBestSellerProducts(int $month, int $year);
    public function getBestSellerCategories(int $month, int $year);
    public function getBestSellerBrands(int $month, int $year);
}
