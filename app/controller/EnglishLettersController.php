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
     * 分析字串並自動轉換為大寫
     * @param string $input 輸入的字串
     * @return array [success, message, data]
     */
    public function analyzeAndConvertToUpper($input)
    {
        $error = $this->validator->validateEnglishInput($input);
        if ($error) {
            return [
                'success' => false,
                'message' => $error,
                'data' => null
            ];
        }

        $upperInput = strtoupper($input);
        $characters = [];

        for ($i = 0; $i < strlen($upperInput); $i++) {
            $char = $upperInput[$i];
            $characters[] = [
                'char' => $char,
                'ascii' => ord($char)
            ];
        }

        return [
            'success' => true,
            'message' => '分析成功',
            'data' => [
                'original' => $input,
                'converted' => $upperInput,
                'length' => strlen($upperInput),
                'characters' => $characters
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
