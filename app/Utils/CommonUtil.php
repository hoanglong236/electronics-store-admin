<?php

namespace App\Utils;

class CommonUtil
{
    private function __construct()
    {
    }

    public static function escapeKeyword(string $keyword)
    {
        $searchPatterns = ['%', '_'];
        $replacePatterns = ['\%', '\_'];
        return str_replace($searchPatterns, $replacePatterns, $keyword);
    }

    public static function convertMapToParamsString($map)
    {
        $str = '';
        foreach ($map as $key => $value) {
            $str .= $key . '=' . ($value ?? '') . '&';
        }
        return substr($str, 0, -1);
    }
}
