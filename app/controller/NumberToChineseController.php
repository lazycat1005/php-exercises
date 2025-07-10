<?php

namespace App\Controller;

class NumberToChineseController
{
    /**
     * 將數字轉換為中文大寫金額
     * @param int $number
     * @return string
     */
    public static function convert($number)
    {
        if ($number === 0) {
            return '零圓整';
        }
        $digits = ['零', '壹', '貳', '參', '肆', '伍', '陸', '柒', '捌', '玖'];
        $smallUnits = ['', '拾', '佰', '仟'];
        $bigUnits = ['', '萬'];

        $convertFour = function ($num) use ($digits, $smallUnits) {
            if ($num === 0) return '';
            $str = str_pad((string)$num, 4, '0', STR_PAD_LEFT);
            $result = '';
            $needZero = false;
            for ($i = 0; $i < 4; $i++) {
                $d = intval($str[$i]);
                if ($d === 0) {
                    $needZero = true;
                } else {
                    if ($needZero && $result !== '') {
                        $result .= '零';
                    }
                    $result .= $digits[$d] . $smallUnits[3 - $i];
                    $needZero = false;
                }
            }
            return $result;
        };

        $wan = intdiv($number, 10000);
        $qian = $number % 10000;
        $result = '';
        if ($wan) {
            $result .= $convertFour($wan) . '萬';
        }
        if ($qian) {
            if ($wan && $qian < 1000) $result .= '零';
            $result .= $convertFour($qian);
        }
        return $result . '圓整';
    }
}
