<?php

namespace App\ModelConstants;

class OrderStatusConstants
{
    const RECEIVED = 'received';
    const PROCESSING = 'processing';
    const DELIVERING = 'delivering';
    const COMPLETED = 'completed';
    const CANCELLED = 'cancelled';

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
