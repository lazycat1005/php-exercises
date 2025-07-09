<?php

namespace App\Validator;

class TextLengthValidator
{
    /**
     * 驗證字串長度
     * @param string $text
     * @param int $limit
     * @return string|null 錯誤訊息或 null
     */
    public function validateText($text, $limit = 1000)
    {
        if (!is_string($text)) {
            return '請輸入文字';
        }
        $text = trim($text);
        if ($text === '') {
            return '請輸入文字';
        }
        if (mb_strlen($text) > $limit) {
            return "字數不可超過 $limit 字";
        }
        return null;
    }
}
