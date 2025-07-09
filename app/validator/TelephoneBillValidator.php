<?php

namespace App\Validator;

class TelephoneBillValidator
{
    /**
     * 驗證通話時長
     * @param mixed $duration
     * @return string|null 錯誤訊息或 null
     */
    public function validateDuration($duration)
    {
        if (!is_numeric($duration) || $duration < 0 || preg_match('/e/i', $duration)) {
            return '請輸入有效的通話時長。';
        }
        if ($duration > 44640) {
            return '通話時長過長，請輸入合理數值。';
        }
        return null;
    }
}
