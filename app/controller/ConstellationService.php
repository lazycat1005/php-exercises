<?php

namespace App\Controller;

use DateTime;

class ConstellationService
{
    /**
     * 根據生日月份與日期回傳星座名稱
     * @param int $month
     * @param int $day
     * @return string
     */
    public static function getConstellation($month, $day)
    {
        $constellations = [
            ["name" => "摩羯座", "start" => [12, 22], "end" => [1, 19]],
            ["name" => "水瓶座", "start" => [1, 20], "end" => [2, 18]],
            ["name" => "雙魚座", "start" => [2, 19], "end" => [3, 20]],
            ["name" => "牡羊座", "start" => [3, 21], "end" => [4, 19]],
            ["name" => "金牛座", "start" => [4, 20], "end" => [5, 20]],
            ["name" => "雙子座", "start" => [5, 21], "end" => [6, 20]],
            ["name" => "巨蟹座", "start" => [6, 21], "end" => [7, 22]],
            ["name" => "獅子座", "start" => [7, 23], "end" => [8, 22]],
            ["name" => "處女座", "start" => [8, 23], "end" => [9, 22]],
            ["name" => "天秤座", "start" => [9, 23], "end" => [10, 23]],
            ["name" => "天蠍座", "start" => [10, 24], "end" => [11, 22]],
            ["name" => "射手座", "start" => [11, 23], "end" => [12, 21]],
        ];
        foreach ($constellations as $c) {
            $startMonth = $c["start"][0];
            $startDay = $c["start"][1];
            $endMonth = $c["end"][0];
            $endDay = $c["end"][1];
            if (
                ($month == $startMonth && $day >= $startDay) ||
                ($month == $endMonth && $day <= $endDay) ||
                ($startMonth > $endMonth && (
                    ($month == $startMonth && $day >= $startDay) ||
                    ($month == $endMonth && $day <= $endDay)
                ))
            ) {
                return $c["name"];
            }
        }
        return "未知";
    }

    /**
     * 根據年分與紀元方式回傳生肖名稱
     * @param int $year
     * @param string $eraType "西元" 或 "民國"
     * @return string
     */
    public static function getZodiac($year, $eraType)
    {
        if ($eraType === '民國') {
            $year = (int)$year + 1911;
        } else {
            $year = (int)$year;
        }
        $zodiacs = [
            '鼠',
            '牛',
            '虎',
            '兔',
            '龍',
            '蛇',
            '馬',
            '羊',
            '猴',
            '雞',
            '狗',
            '豬'
        ];
        $index = ($year - 1900) % 12;
        if ($index < 0) {
            $index += 12;
        }
        return $zodiacs[$index];
    }

    /**
     * 計算實際年齡
     * @param int $birthYear
     * @param int $birthMonth
     * @param int $birthDay
     * @return int
     */
    public static function calculateAge($birthYear, $birthMonth, $birthDay)
    {
        $today = new DateTime();
        $birthDate = new DateTime("$birthYear-$birthMonth-$birthDay");
        $age = $today->diff($birthDate);
        return $age->y;
    }
}
