<?php

namespace App\Validator;

class LeapYearValidator
{
    /**
     * 驗證年份是否合法
     * @param mixed $year
     * @return string|null 錯誤訊息或 null
     */

    private $errorMsg = null;

    public function validateYear($year)
    {
        // 若是用...$args 就要寫 [$year] = $args;
        if (!is_numeric($year) || intval($year) != $year) {
            $this->errorMsg = '請輸入有效的整數年份。';
            return false;
        }
        $year = intval($year);
        if ($year < 1 || $year > 3000) {
            $this->errorMsg = '請輸入有效的年份 (1-3000)。';
            return false;
        }
        return true;
    }
    public function getErrorMsg()
    {
        return $this->errorMsg;
    }
}

function validate($someInput)
{
    if ($someInput) {
        // 這裡可以放入驗證邏輯
        return true;
    } else {
        // 如果驗證失敗，返回錯誤訊息
        return false;
    }
}

function getErrorMsg()
{
    return $this->errorMsg;
}
