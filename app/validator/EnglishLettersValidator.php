<?php

namespace App\Validator;

class EnglishLettersValidator
{
    /**
     * 驗證英文字母輸入（字串，大小寫皆可）
     * @param string $input
     * @return string|null 錯誤訊息或 null
     */
    public function validateEnglishInput($input)
    {
        if (!is_string($input) || $input === '') {
            return '請輸入英文字串';
        }

        if (!preg_match('/^[A-Za-z]+$/', $input)) {
            return '只能輸入英文字母';
        }

        return null;
    }

    /**
     * 驗證輸入字串（非空字串）
     * @param string $string
     * @return string|null 錯誤訊息或 null
     */
    public function validateString($string)
    {
        if (!is_string($string) || $string === '') {
            return '請輸入非空字串';
        }
        return null;
    }
}
