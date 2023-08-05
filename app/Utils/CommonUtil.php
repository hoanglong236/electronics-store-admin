<?php

namespace App\Utils;

class CommonUtil
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
}
