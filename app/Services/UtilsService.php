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

    public static function dateToEndOfDate(string $date) {
        return $date . ' 23:59:59.999999';
    }
}
