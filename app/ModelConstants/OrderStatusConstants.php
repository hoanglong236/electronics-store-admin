<?php

namespace App\ModelConstants;

class OrderStatusConstants
{
    const RECEIVED = 'Received';
    const PROCESSING = 'Processing';
    const DELIVERING = 'Delivering';
    const COMPLETED = 'Completed';
    const CANCELLED = 'Cancelled';

    private function __construct()
    {
    }

    public static function toArray()
    {
        return [
            static::RECEIVED,
            static::PROCESSING,
            static::DELIVERING,
            static::COMPLETED,
            static::CANCELLED,
        ];
    }
}
