<?php
class MultiplicationTableValidator
{
    /**
     * 驗證輸入是否合法
     * @param string $input
     * @return string|null 錯誤訊息或 null
     */
    public function validateInput($input)
    {
        if (!is_string($input) || trim($input) === '') {
            return '請輸入欲產生的乘法表數字';
        }
        // 僅允許數字、逗號、全形逗號、~、-、空白
        if (!preg_match('/^[0-9,，~\- ]+$/u', $input)) {
            return '請勿輸入文字、科學符號、運算符號、小數點或超過9的數字';
        }
        // 解析後不得超過9
        $numbers = preg_split('/[ ,，]+/', $input, -1, PREG_SPLIT_NO_EMPTY);
        foreach ($numbers as $n) {
            if (is_numeric($n) && intval($n) > 9) {
                return '請勿輸入超過9的數字';
            }
        }
        return null;
    }
}
