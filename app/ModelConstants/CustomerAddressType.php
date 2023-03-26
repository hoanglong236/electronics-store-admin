<?php

namespace App\ModelConstants;

class CustomerAddressType
{
    const HOME = 'Home';
    const OFFICE = 'Office';

    private function __construct()
    {
    }

    public static function toArray()
    {
        return [
            static::HOME,
            static::OFFICE,
        ];
    }
}
