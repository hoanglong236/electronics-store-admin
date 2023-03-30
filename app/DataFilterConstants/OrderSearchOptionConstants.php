<?php

namespace App\DataFilterConstants;

class OrderSearchOptionConstants
{
    const ALL = 'All';
    const CUSTOMER = 'Customer';
    const ADDRESS = 'Address';

    private function __construct()
    {
    }

    public static function toArray()
    {
        return [
            static::ALL,
            static::CUSTOMER,
            static::ADDRESS,
        ];
    }
}
