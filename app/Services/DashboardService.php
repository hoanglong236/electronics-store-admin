<?php

namespace App\Services;

use App\Models\Constants\PaymentMethodConstants;
use App\Repositories\IDashboardRepository;

class DashboardService
{
    private $dashboardRepository;

    public function __construct(IDashboardRepository $dashboardRepository)
    {
        $this->dashboardRepository = $dashboardRepository;
    }

    public function getDashboardData(string $date)
    {
        $data = [];

        $data['newCustomersCount'] = $this->dashboardRepository->getNumberNewCustomers($date);
        $data['revenue'] = $this->dashboardRepository->getRevenue($date);

        $orderQtyByPaymentMethods = [];
        foreach (PaymentMethodConstants::toArray() as $paymentMethod) {
            $orderQtyByPaymentMethods[$paymentMethod] = 0;
        }
        $totalOrderQty = 0;
        $orderQtyArray = $this->dashboardRepository->getOrderQtyByPaymentMethods($date, PaymentMethodConstants::toArray());
        foreach ($orderQtyArray as $item) {
            $totalOrderQty += $item->qty;
            $orderQtyByPaymentMethods[$item->payment_method] = $item->qty;
        }

        $data['orderQty'] = $totalOrderQty;
        $data['orderQtyByPaymentMethods'] = $orderQtyByPaymentMethods;

        return $data;
    }
}
