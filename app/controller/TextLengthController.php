<?php

namespace App\Controller;

use App\Validator\TextLengthValidator;

class TextLengthController
{
    private $validator;

    public function __construct()
    {
        $this->validator = new TextLengthValidator();
    }

    /**
     * 計算字數與驗證
     * @param string $text
     * @param int $limit
     * @return array [success, count, html]
     */
    public function calculateTextLength($text, $limit = 1000)
    {
        $error = $this->validator->validateText($text, $limit);
        if ($error) {
            return [
                'success' => false,
                'count' => 0,
                'html' => "<p style='color:red;'>$error</p>"
            ];
        }
        $count = mb_strlen($text);
        $html = "<p>字元個數: $count</p>";
        return [
            'success' => true,
            'count' => $count,
            'html' => $html
        ];
    }
}
