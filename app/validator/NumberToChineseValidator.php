<?php

namespace App\Validator;

class NumberToChineseValidator
{
    /**
     * 驗證數字是否在允許範圍 0~9999999
     * @param mixed $number
     * @return bool
     */
    public static function validate($number): bool
    {
        if (!is_numeric($number)) {
            return false;
        }
        $number = intval($number);
        return $number >= 0 && $number <= 9999999;
    }
}
