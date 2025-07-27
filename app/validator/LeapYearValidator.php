<?php

namespace App\Validator;

class LeapYearValidator
{
    /**
     * 驗證年份是否合法
     * @param mixed $year
     * @return bool 是否通過驗證
     */
    public function validateYear($year)
    {
        if (!is_numeric($year) || intval($year) != $year) {
            return false;
        }
        $year = intval($year);
        if ($year < 1 || $year > 3000) {
            return false;
        }
        return true;
    }

    /**
     * 取得年份驗證錯誤訊息
     * @param mixed $year
     * @return string|null 錯誤訊息或 null
     */
    public function getErrorMessage($year)
    {
        if (!is_numeric($year) || intval($year) != $year) {
            return '請輸入有效的整數年份。';
        }
        $year = intval($year);
        if ($year < 1 || $year > 3000) {
            return '請輸入有效的年份 (1-3000)。';
        }
        return null;
    }
}
