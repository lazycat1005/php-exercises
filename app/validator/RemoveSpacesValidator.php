<?php

namespace App\Validator;

class RemoveSpacesValidator
{
    /**
     * 驗證輸入字串
     * @param mixed $input
     * @return string|null 錯誤訊息或 null
     */
    public function validateInput($input)
    {
        if (!is_string($input)) {
            return '請輸入有效的字串。';
        }
        if (mb_strlen($input) > 200) {
            return '字串長度不可超過 200 字元。';
        }
        return null;
    }
}
