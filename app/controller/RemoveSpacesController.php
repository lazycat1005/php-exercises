<?php
require_once __DIR__ . '/../validator/RemoveSpacesValidator.php';

class RemoveSpacesController
{
    private $validator;

    public function __construct()
    {
        $this->validator = new RemoveSpacesValidator();
    }

    /**
     * 處理移除空格的請求
     * @param string $input
     * @return array [success, filtered, html]
     */
    public function removeSpaces($input)
    {
        $error = $this->validator->validateInput($input);
        if ($error) {
            return [
                'success' => false,
                'filtered' => '',
                'html' => "<p>{$error}</p>"
            ];
        }
        $filtered = preg_replace('/\s+/', '', $input);
        return [
            'success' => true,
            'filtered' => $filtered,
            'html' => ''
        ];
    }
}
