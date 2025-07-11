<?php

namespace App\Controller;

use App\Validator\PerpetualCalendarValidator;
use App\Helper\PerpetualCalendarHelper;

class PerpetualCalendarController
{
    public static function handle(?string $year, ?string $month): string
    {
        if (isset($year, $month)) {
            if (PerpetualCalendarValidator::validate($year, $month)) {
                return PerpetualCalendarHelper::generateCalendar((int)$year, (int)$month);
            } else {
                return '<tr><td colspan="7">請輸入有效的年與月。</td></tr>';
            }
        }
        return '';
    }
}
