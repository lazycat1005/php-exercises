<?php

class Validator
{
    public function validateTemperature($value, $label): string
    {
        $trimmed = trim($value);
        $isEmpty = $trimmed === '';
        $isInvalid = preg_match('/e/i', $trimmed);
        $isNumeric = is_numeric($trimmed);

        if ($isEmpty) {
            return "請輸入{$label}溫度來進行轉換。";
        } elseif ($isInvalid) {
            return "無效的值（不能包含科學記號）。";
        } elseif (!$isNumeric) {
            return "{$label}溫度無效，請輸入數字。";
        }
        return ''; // 表示驗證通過
    }
}
