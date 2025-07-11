<?php

namespace App\Validator;

class PerpetualCalendarValidator
{
    public static function isValidPositiveInteger($value): bool
    {
        return is_numeric($value) && ctype_digit($value) && intval($value) > 0;
    }

    public static function validate($year, $month): bool
    {
        return self::isValidPositiveInteger($year)
            && self::isValidPositiveInteger($month)
            && intval($year) > 0
            && intval($month) >= 1
            && intval($month) <= 12;
    }
}
