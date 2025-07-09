<?php

namespace App\Controller;

use App\Validator\EnglishLettersValidator;

class EnglishLettersController
{
    private $validator;

    public function __construct()
    {
        $this->validator = new EnglishLettersValidator();
    }

    /**
     * @param string $char 單一字元
     * @param string $mode 模式: 'upper' 僅大寫, 'both' 大小寫皆可
     * @return array [success, message, data]
     */
    public function analyzeCharacter($char, $mode = 'both')
    {
        $error = $this->validator->validateCharacter($char, $mode);
        if ($error) {
            return [
                'success' => false,
                'message' => $error,
                'data' => null
            ];
        }
        $ascii = ord($char);
        $type = (ctype_upper($char)) ? '大寫' : '小寫';
        return [
            'success' => true,
            'message' => '分析成功',
            'data' => [
                'char' => $char,
                'ascii' => $ascii,
                'type' => $type
            ]
        ];
    }

    /**
     * 分析一串字元，回傳每個字元的 ASCII 及類型
     * @param string $string
     * @return array [success, message, data]
     */
    public function analyzeString($string)
    {
        if (!is_string($string) || $string === '') {
            return [
                'success' => false,
                'message' => '請輸入非空字串',
                'data' => null
            ];
        }
        $result = [];
        $length = mb_strlen($string, 'UTF-8');
        for ($i = 0; $i < $length; $i++) {
            $char = mb_substr($string, $i, 1, 'UTF-8');
            $ascii = (strlen($char) === 1) ? ord($char) : null;
            if (preg_match('/^[A-Z]$/', $char)) {
                $type = '英文大寫';
            } elseif (preg_match('/^[a-z]$/', $char)) {
                $type = '英文小寫';
            } elseif ($ascii !== null && $ascii >= 33 && $ascii <= 126 && !preg_match('/^[A-Za-z0-9]$/', $char)) {
                $type = '半形符號';
            } else {
                $type = '其他字元';
            }
            $result[] = [
                'char' => $char,
                'ascii' => $ascii,
                'type' => $type
            ];
        }
        return [
            'success' => true,
            'message' => '分析成功',
            'data' => $result
        ];
    }
}
