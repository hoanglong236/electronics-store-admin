<?php

namespace App\Repositories;

interface IDashboardRepository
{
    public function getNumberNewCustomers(string $date);
    public function getRevenue(string $date);

    public function getOrderQtyByPaymentMethods(string $date, array $paymentMethods);
}
