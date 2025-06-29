<?php

namespace Lib;

class MultiplicationTableHelper
{
    /**
     * 驗證輸入是否合法
     */
    public static function isValidInput($input)
    {
        if (!preg_match('/^[0-9,，~\- ]+$/u', $input)) {
            return false;
        }
        $input = str_replace(['，', ' '], [',', ''], $input);
        $parts = explode(',', $input);
        foreach ($parts as $part) {
            if (strpos($part, '~') !== false || strpos($part, '-') !== false) {
                $range = preg_split('/[~\-]/', $part);
                if (count($range) === 2) {
                    $start = (int)$range[0];
                    $end = (int)$range[1];
                    if ($start > 9 || $end > 9) {
                        return false;
                    }
                }
            } elseif (is_numeric($part) && $part !== '') {
                if ((int)$part > 9) {
                    return false;
                }
            }
        }
        return true;
    }

    /**
     * 解析使用者輸入，回傳乘法表數字陣列
     */
    public static function parseTableInput($input)
    {
        $input = str_replace(['，', ' '], [',', ''], $input);
        $parts = explode(',', $input);
        $numbers = [];
        foreach ($parts as $part) {
            if (strpos($part, '~') !== false || strpos($part, '-') !== false) {
                $range = preg_split('/[~\-]/', $part);
                if (count($range) === 2) {
                    $start = (int)$range[0];
                    $end = (int)$range[1];
                    if ($start > $end) {
                        [$start, $end] = [$end, $start];
                    }
                    for ($i = $start; $i <= $end; $i++) {
                        if ($i >= 1 && $i <= 9) {
                            $numbers[] = $i;
                        }
                    }
                }
            } elseif (is_numeric($part)) {
                $num = (int)$part;
                if ($num >= 1 && $num <= 9) {
                    $numbers[] = $num;
                }
            }
        }
        $numbers = array_unique($numbers);
        sort($numbers);
        return $numbers;
    }
}
