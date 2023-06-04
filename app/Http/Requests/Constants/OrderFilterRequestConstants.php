<?php

namespace App\Http\Requests\Constants;

use App\ModelConstants\OrderStatusConstants;
use App\ModelConstants\PaymentMethodConstants;

class OrderFilterRequestConstants
{
    const ALL = 'All';

    const STATUS_RECEIVED = OrderStatusConstants::RECEIVED;
    const STATUS_PROCESSING = OrderStatusConstants::PROCESSING;
    const STATUS_DELIVERING = OrderStatusConstants::DELIVERING;
    const STATUS_COMPLETED = OrderStatusConstants::COMPLETED;
    const STATUS_CANCELLED = OrderStatusConstants::CANCELLED;

    const PAYMENT_METHOD_COD = PaymentMethodConstants::COD;
    const PAYMENT_METHOD_VISA = PaymentMethodConstants::VISA;

    private function __construct()
    {
    }

    public static function statusArray()
    {
        return [
            static::ALL,
            static::STATUS_RECEIVED,
            static::STATUS_PROCESSING,
            static::STATUS_DELIVERING,
            static::STATUS_COMPLETED,
            static::STATUS_CANCELLED,
        ];
    }

    public static function paymentMethodArray()
    {
        return [
            static::ALL,
            static::PAYMENT_METHOD_COD,
            static::PAYMENT_METHOD_VISA,
        ];
    }
}
