<?php

namespace App\DataFilterConstants;

class CategorySearchOptionConstants
{
    const SEARCH_ALL = 'All';
    const SEARCH_NAME = 'Name';
    const SEARCH_SLUG = 'Slug';
    const SEARCH_PARENT = 'Parent';

    private function __construct()
    {
    }

    public static function toArray()
    {
        return [
            static::SEARCH_ALL,
            static::SEARCH_NAME,
            static::SEARCH_SLUG,
            static::SEARCH_PARENT,
        ];
    }
}
