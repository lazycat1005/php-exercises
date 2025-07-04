<?php
require_once __DIR__ . '/../validator/27LeapYearValidator.php';

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
     * @return array [success, html]
     */
    public function calculateLeapYear($year)
    {
        $error = $this->validator->validateYear($year);
        if ($error) {
            return [
                'success' => false,
                'html' => "<p>{$error}</p>"
            ];
        }
        $year = intval($year);
        $date = new DateTime("$year-01-01");
        $isLeap = $date->format('L') ? true : false;
        $days = $isLeap ? 366 : 365;
        $isLeapText = $isLeap ? '是' : '否';
        $html = "<p>年份: $year</p>\n<p>總天數: $days 天</p>\n<p>是否為閏年: $isLeapText</p>";
        return [
            'success' => true,
            'html' => $html
        ];
    }
}
