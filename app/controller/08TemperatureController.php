<?php
require_once __DIR__ . '/../validator/08TemperatureValidator.php';

class TemperatureController
{
    private $validator;

    public function __construct()
    {
        $this->validator = new TemperatureValidator();
    }

    /**
     * 統一溫度轉換處理
     * @param mixed $value
     * @param string $fromUnit
     * @param string $toUnit
     * @param string $label
     * @return array
     */
    public function convertTemperature($value, $fromUnit, $toUnit, $label = '')
    {
        $error = $this->validator->validateTemperature($value, $fromUnit, $toUnit, $label);
        if ($error) {
            return ['success' => false, 'message' => $error];
        }
        $result = $this->calculateConversion($value, $fromUnit, $toUnit);
        return ['success' => true, 'result' => $result];
    }

    private function calculateConversion($value, $from, $to)
    {
        $value = floatval($value);
        if ($from === $to) {
            return $value;
        }
        // 攝氏轉華氏
        if ($from === 'C' && $to === 'F') {
            return $value * 9 / 5 + 32;
        }
        // 華氏轉攝氏
        if ($from === 'F' && $to === 'C') {
            return ($value - 32) * 5 / 9;
        }
        return null;
    }

    /**
     * 處理 AJAX 請求
     * @return void
     */
    public function handleAjaxRequest()
    {
        header('Content-Type: application/json');

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            echo json_encode([
                'success' => false,
                'message' => '無效的請求方法。'
            ]);
            return;
        }

        $temperature = $_POST['temperature'] ?? null;
        $unit = $_POST['unit'] ?? null;

        // 前端傳來的 unit 轉換成 Controller 需要的格式
        $fromUnit = null;
        $toUnit = null;
        if ($unit === 'celsius') {
            $fromUnit = 'C';
            $toUnit = 'F';
        } elseif ($unit === 'fahrenheit') {
            $fromUnit = 'F';
            $toUnit = 'C';
        }

        $result = $this->convertTemperature($temperature, $fromUnit, $toUnit);

        if ($result['success']) {
            // 統一回傳格式
            if ($fromUnit === 'C') {
                echo json_encode([
                    'success' => true,
                    'celsius' => floatval($temperature),
                    'fahrenheit' => round($result['result'], 2)
                ]);
            } else {
                echo json_encode([
                    'success' => true,
                    'fahrenheit' => floatval($temperature),
                    'celsius' => round($result['result'], 2)
                ]);
            }
        } else {
            echo json_encode([
                'success' => false,
                'message' => $result['message']
            ]);
        }
    }
}
