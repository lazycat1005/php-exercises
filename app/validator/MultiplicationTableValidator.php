<?php

namespace App\Validator;

class MultiplicationTableValidator extends BaseValidator
{
    /**
     * 驗證乘法表輸入格式
     * 支援的格式：
     * - 單一數字：1
     * - 多個數字（逗號分隔）：1,3,5
     * - 範圍：2~4
     * - 混合：1,3~5,7
     * 
     * @param string $input 使用者輸入的字串
     * @return bool 驗證是否通過
     * @throws \InvalidArgumentException 當輸入格式錯誤時拋出例外
     */
    public function validate(...$args): bool
    {
        $input = $args[0] ?? '';

        // 檢查是否為空
        if (empty(trim($input))) {
            throw new \InvalidArgumentException('請輸入要生成的乘法表數量');
        }

        // 移除所有空白字元
        $cleanInput = preg_replace('/\s+/', '', $input);

        // 驗證基本格式：只允許數字、逗號、波浪號
        if (!preg_match('/^[0-9,~]+$/', $cleanInput)) {
            throw new \InvalidArgumentException('輸入格式錯誤，只能包含數字、逗號(,)和波浪號(~)');
        }

        // 分割逗號
        $parts = explode(',', $cleanInput);

        foreach ($parts as $part) {
            if (empty($part)) {
                throw new \InvalidArgumentException('輸入格式錯誤，不能有空的部分');
            }

            // 檢查是否為範圍格式 (例如: 2~4)
            if (strpos($part, '~') !== false) {
                if (!$this->validateRange($part)) {
                    return false;
                }
            } else {
                // 檢查單一數字
                if (!$this->validateSingleNumber($part)) {
                    return false;
                }
            }
        }

        return true;
    }

    /**
     * 驗證單一數字
     * 
     * @param string $number 數字字串
     * @return bool 驗證是否通過
     * @throws \InvalidArgumentException 當數字格式錯誤時拋出例外
     */
    private function validateSingleNumber(string $number): bool
    {
        // 檢查是否為正整數
        if (!ctype_digit($number)) {
            throw new \InvalidArgumentException('請輸入正整數');
        }

        $num = (int)$number;

        // 檢查範圍 (1-9，因為這是九九乘法表)
        if ($num < 1 || $num > 9) {
            throw new \InvalidArgumentException('數字必須在 1-9 範圍內');
        }

        return true;
    }

    /**
     * 驗證範圍格式
     * 
     * @param string $range 範圍字串 (例如: 2~4)
     * @return bool 驗證是否通過
     * @throws \InvalidArgumentException 當範圍格式錯誤時拋出例外
     */
    private function validateRange(string $range): bool
    {
        // 檢查波浪號數量
        if (substr_count($range, '~') !== 1) {
            throw new \InvalidArgumentException('範圍格式錯誤，應該使用單一波浪號(~)分隔');
        }

        // 分割範圍
        $rangeParts = explode('~', $range);

        if (count($rangeParts) !== 2) {
            throw new \InvalidArgumentException('範圍格式錯誤');
        }

        $start = trim($rangeParts[0]);
        $end = trim($rangeParts[1]);

        // 檢查起始和結束數字
        if (!$this->validateSingleNumber($start) || !$this->validateSingleNumber($end)) {
            return false;
        }

        $startNum = (int)$start;
        $endNum = (int)$end;

        // 檢查範圍邏輯
        if ($startNum >= $endNum) {
            throw new \InvalidArgumentException('範圍的起始數字必須小於結束數字');
        }

        return true;
    }

    /**
     * 解析使用者輸入並回傳數字陣列
     * 
     * @param string $input 使用者輸入
     * @return array 解析後的數字陣列
     */
    public function parseInput(string $input): array
    {
        $numbers = [];
        $cleanInput = preg_replace('/\s+/', '', $input);
        $parts = explode(',', $cleanInput);

        foreach ($parts as $part) {
            if (strpos($part, '~') !== false) {
                // 處理範圍
                $rangeParts = explode('~', $part);
                $start = (int)$rangeParts[0];
                $end = (int)$rangeParts[1];

                for ($i = $start; $i <= $end; $i++) {
                    $numbers[] = $i;
                }
            } else {
                // 處理單一數字
                $numbers[] = (int)$part;
            }
        }

        // 去除重複並排序
        $numbers = array_unique($numbers);
        sort($numbers);

        return $numbers;
    }
}
