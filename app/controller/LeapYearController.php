<?php

namespace App\Controller;

use App\Validator\LeapYearValidator;
use DateTime;

class LeapYearController
{
    private $validator;

    public function __construct()
    {
        $this->validator = new LeapYearValidator();
    }

    /**
     * 計算閏年與天數
     * @param int|string $year
     * @return array
     */
    public function calculateLeapYear($year)
    {
        if (!$this->validator->validateYear($year)) {
            return [
                'success' => false,
                'error' => $this->validator->getErrorMessage($year)
            ];
        }

        $year = intval($year);
        $date = new DateTime("$year-01-01");
        $isLeap = $date->format('L') ? true : false;
        $days = $isLeap ? 366 : 365;

        return [
            'year' => $year,
            'days' => $days,
            'isLeap' => $isLeap
        ];
    }
}
