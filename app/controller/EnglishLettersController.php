<?php
// app/controller/EnglishLettersController.php
require_once __DIR__ . '/../validator/EnglishLettersValidator.php';

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
}
