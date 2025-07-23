<?php

namespace App\Validator;

class ReceiptPrizeCheckerValidator
{
    //驗證函數(使用正則表達式)，使用者可輸入3~8位數字，但不可含有字串與浮點數、正負號，若驗證失敗返回false
    public static function validateReceipt($receipt)
    {
        if (preg_match('/^\d{3,8}$/', $receipt)) {
            return true;
        }
        return false;
    }
}
