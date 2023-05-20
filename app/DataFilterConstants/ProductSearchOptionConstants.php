<?php

namespace App\DataFilterConstants;

class ProductSearchOptionConstants
{
    const SEARCH_ALL = 'All';
    const SEARCH_CATEGORY = 'Category';
    const SEARCH_BRAND = 'Brand';

    private function __construct()
    {
    }

    public static function toArray()
    {
        return [
            static::SEARCH_ALL,
            static::SEARCH_CATEGORY,
            static::SEARCH_BRAND,
        ];
    }
}
