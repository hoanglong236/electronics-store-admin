<?php

namespace App\ModelConstants;

class CustomerAddressType
{
    const HOME = 'home';
    const OFFICE = 'office';

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
