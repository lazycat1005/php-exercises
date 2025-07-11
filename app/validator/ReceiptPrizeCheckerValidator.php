<?php

namespace App\Validator;

class ReceiptPrizeCheckerValidator
{
    /**
     * 驗證發票號碼格式 (3~8位數字)
     * @param string $receipt
     * @return bool|string 通過回傳 true，否則回傳錯誤訊息
     */
    public static function validateReceipt(string $receipt)
    {
        if (!preg_match('/^[0-9]{3,8}$/', $receipt)) {
            return '請輸入 3~8 位數的有效發票號碼。';
        }
        return true;
    }
}
