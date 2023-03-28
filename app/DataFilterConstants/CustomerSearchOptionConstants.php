<?php

namespace App\DataFilterConstants;

class CustomerSearchOptionConstants
{
    const SEARCH_ALL = 'All';
    const SEARCH_NAME = 'Name';
    const SEARCH_EMAIL = 'Email';
    const SEARCH_PHONE = 'Phone';

    private function __construct()
    {
    }

    public static function toArray()
    {
        return [
            static::SEARCH_ALL,
            static::SEARCH_NAME,
            static::SEARCH_EMAIL,
            static::SEARCH_PHONE,
        ];
    }
}
