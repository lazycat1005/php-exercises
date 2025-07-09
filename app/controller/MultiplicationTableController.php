<?php

namespace App\Controller;

use App\Validator\MultiplicationTableValidator;

class MultiplicationTableController
{
    private $validator;

    public function __construct()
    {
        $this->validator = new MultiplicationTableValidator();
    }

    /**
     * 產生九九乘法表資料
     * @param string $input
     * @return array [success, numbers, error]
     */
    public function generateTable($input)
    {
        $error = $this->validator->validateInput($input);
        if ($error) {
            return [
                'success' => false,
                'numbers' => [],
                'error' => $error
            ];
        }
        $numbers = $this->parseTableInput($input);
        return [
            'success' => true,
            'numbers' => $numbers,
            'error' => ''
        ];
    }

    /**
     * 解析使用者輸入，回傳乘法表數字陣列
     */
    private function parseTableInput($input)
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
