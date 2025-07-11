<?php

namespace App\Validator;

class EnglishLettersValidator
{
    /**
     * 驗證輸入字元
     * @param string $char
     * @param string $mode 'upper' 僅大寫, 'both' 大小寫皆可
     * @return string|null 錯誤訊息或 null
     */
    public function validateCharacter($char, $mode = 'both')
    {
        if (mb_strlen($char) !== 1) {
            return '請輸入單一英文字母';
        }
        if ($mode === 'upper') {
            if (!ctype_upper($char)) {
                return '僅允許大寫英文字母';
            }
        } else {
            if (!ctype_alpha($char)) {
                return '僅允許英文字母';
            }
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
