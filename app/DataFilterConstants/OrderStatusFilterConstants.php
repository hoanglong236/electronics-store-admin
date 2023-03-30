<?php

namespace App\DataFilterConstants;

use App\ModelConstants\OrderStatusConstants;

class OrderStatusFilterConstants
{
    const ALL = 'All';
    const RECEIVED = OrderStatusConstants::RECEIVED;
    const PROCESSING = OrderStatusConstants::PROCESSING;
    const DELIVERING = OrderStatusConstants::DELIVERING;
    const COMPLETED = OrderStatusConstants::COMPLETED;
    const CANCELLED = OrderStatusConstants::CANCELLED;

    private function __construct()
    {
    }

    public static function toArray()
    {
        return [
            static::ALL,
            static::RECEIVED,
            static::PROCESSING,
            static::DELIVERING,
            static::COMPLETED,
            static::CANCELLED,
        ];
    }
}
