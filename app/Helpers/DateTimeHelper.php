<?php

namespace App\Helpers;

class DateTimeHelper
{
    private function __construct()
    {
    }

    public static function dateToEndOfDate(string $date)
    {
        return $date . ' 23:59:59.999999';
    }

    public static function getLastDayOfMonth(int $month, $year)
    {
        $date = new \DateTime($year . '/' . str_pad($month, 2, '0', STR_PAD_LEFT) . '/01');
        return intval($date->format('t'));
    }

    public static function getFirstDateOfMonth(int $month, int $year)
    {
        return $year . '/' . str_pad($month, 2, '0', STR_PAD_LEFT) . '/01';
    }

    public static function getLastDateOfMonth(int $month, int $year)
    {
        $date = new \DateTime(static::getFirstDateOfMonth($month, $year));
        return $date->format('Y/m/t');
    }
}
