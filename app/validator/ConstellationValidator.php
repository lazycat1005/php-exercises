<?php

namespace App\Validator;

class ConstellationValidator
{
    /**
     * 驗證生日輸入是否合法
     * @param string $year
     * @param string $month
     * @param string $day
     * @return array [bool, string]  (是否通過, 錯誤訊息)
     */
    public static function validateBirthdayInput($year, $month, $day)
    {
        $pattern = '/^(0|[1-9][0-9]*)$/';
        if (!preg_match($pattern, $year) || !preg_match($pattern, $month) || !preg_match($pattern, $day)) {
            return [false, '請輸入正整數的年、月、日，且不可為負數、浮點數、科學符號或字串'];
        }
        $year = (int)$year;
        $month = (int)$month;
        $day = (int)$day;
        if ($year <= 0 || $month <= 0 || $day <= 0) {
            return [false, '年、月、日皆需大於 0'];
        }
        if (!checkdate($month, $day, $year)) {
            return [false, '請輸入正確存在的日期'];
        }
        return [true, ''];
    }
}
