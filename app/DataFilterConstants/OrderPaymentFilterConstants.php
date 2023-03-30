<?php

namespace App\DataFilterConstants;

use App\ModelConstants\PaymentMethodConstants;

class OrderPaymentFilterConstants
{
    const ALL = 'All';
    const COD = PaymentMethodConstants::COD;
    const VISA = PaymentMethodConstants::VISA;

    private function __construct()
    {
    }

    public static function toArray()
    {
        return [
            static::ALL,
            static::COD,
            static::VISA,
        ];
    }
}
