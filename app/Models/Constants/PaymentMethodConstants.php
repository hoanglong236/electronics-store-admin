<?php

namespace App\Models\Constants;

class PaymentMethodConstants
{
    const COD = 'COD';
    const VISA = 'Visa';

    private function __construct()
    {
    }

    public static function toArray()
    {
        return [
            static::COD,
            static::VISA,
        ];
    }
}
