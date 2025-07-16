<?php

namespace App\Validator;

class BinaryValidator
{
    /**
     * 驗證輸入必須為 1~256 的正整數
     * @param mixed $input
     * @return true|string
     */
    public function validateInput($input)
    {
        if ($input === null || $input === '' || trim((string)$input) === '') {
            return '輸入不能為空值';
        }
        if (!preg_match('/^\d+$/', (string)$input)) {
            return '請輸入正整數（不可有小數點、符號或字母）';
        }
        $num = intval($input);
        if ($num < 1 || $num > 256) {
            return '數字必須介於 1 到 256 之間';
        }
        return true;
    }
}
