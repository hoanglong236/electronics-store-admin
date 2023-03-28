<?php

namespace App\DataFilterConstants;

class ProductSearchOptionConstants
{
    const SEARCH_ALL = 'All';
    const SEARCH_NAME = 'Name';
    const SEARCH_SLUG = 'Slug';
    const SEARCH_CATEGORY = 'Category';
    const SEARCH_BRAND = 'Brand';

    private function __construct()
    {
    }

    public static function toArray()
    {
        return [
            static::SEARCH_ALL,
            static::SEARCH_NAME,
            static::SEARCH_SLUG,
            static::SEARCH_CATEGORY,
            static::SEARCH_BRAND,
        ];
    }
}
