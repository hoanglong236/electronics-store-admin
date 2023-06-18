<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;

class UtilsService
{
    private function __construct()
    {
    }

    public static function escapeKeyword(string $keyword)
    {
        $search = array('%', '_');
        $replace = array('\%', '\_');
        return str_replace($search, $replace, $keyword);
    }

    public static function convertMapToParamsString($map)
    {
        $str = '';
        foreach ($map as $key => $value) {
            $str .= $key . '=' . $value . '&';
        }

        return substr($str, 0, -1);
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

    public static function getFirstDateOfNextMonth(int $month, int $year)
    {
        $firstDateOfNextMonth = "";
        if ($month === 12) {
            $firstDateOfNextMonth .= ($year + 1) . '/01/01';
        } else {
            $firstDateOfNextMonth .= $year . '/' . str_pad($month + 1, 2, '0', STR_PAD_LEFT) . '/01';
        }

        return $firstDateOfNextMonth;
    }

    public static function getLastDateOfMonth(int $month, int $year)
    {
        $date = new \DateTime(static::getFirstDateOfMonth($month, $year));
        return $date->format('Y/m/t');
    }
}
