<?php

namespace App\ModelConstants;

class CategoryConstants
{
    const SEARCH_ALL = 'all';
    const SEARCH_NAME = 'name';
    const SEARCH_SLUG = 'slug';

    private function __construct()
    {
    }

    public static function toArray()
    {
        return [
            static::SEARCH_ALL,
            static::SEARCH_NAME,
            static::SEARCH_SLUG,
        ];
    }
}
