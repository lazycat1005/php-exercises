<?php

namespace App\Helper;

class PerpetualCalendarHelper
{
    public static function generateCalendar(int $year, int $month): string
    {
        $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
        $firstWeekday = date('w', $firstDayOfMonth);
        $daysInMonth = date('t', $firstDayOfMonth);
        $html = '<tr>';
        for ($i = 0; $i < $firstWeekday; $i++) {
            $html .= '<td></td>';
        }
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $html .= '<td>' . $day . '</td>';
            if (($day + $firstWeekday) % 7 == 0) {
                $html .= '</tr><tr>';
            }
        }
        while (($daysInMonth + $firstWeekday) % 7 != 0) {
            $html .= '<td></td>';
            $daysInMonth++;
        }
        $html .= '</tr>';
        return $html;
    }
}
