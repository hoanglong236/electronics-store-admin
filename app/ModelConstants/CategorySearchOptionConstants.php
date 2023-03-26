<?php

namespace App\ModelConstants;

class CategorySearchOptionConstants
{
    const SEARCH_ALL = 'All';
    const SEARCH_NAME = 'Name';
    const SEARCH_SLUG = 'Slug';

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
