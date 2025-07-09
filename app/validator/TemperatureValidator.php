<?php

namespace App\Validator;

class TemperatureValidator
{
    /**
     * 驗證溫度數值與單位
     * @param mixed $value
     * @param string $fromUnit
     * @param string $toUnit
     * @param string $label
     * @return string|null
     */
    public function validateTemperature($value, $fromUnit, $toUnit, $label = '')
    {
        $trimmed = trim($value);
        $isEmpty = $trimmed === '';
        $isInvalid = preg_match('/e/i', $trimmed);
        $isNumeric = is_numeric($trimmed);

        if ($isEmpty) {
            return $label ? "請輸入{$label}溫度來進行轉換。" : '請輸入溫度數值';
        } elseif ($isInvalid) {
            return '無效的值（不能包含科學記號）。';
        } elseif (!$isNumeric) {
            return $label ? "{$label}溫度無效，請輸入數字。" : '溫度必須為數字';
        }
        $validUnits = ['C', 'F'];
        if (!in_array($fromUnit, $validUnits) || !in_array($toUnit, $validUnits)) {
            return '單位錯誤';
        }
        return null;
    }
}
