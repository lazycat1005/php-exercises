<?php
require_once __DIR__ . '/../validator/TelephoneBillValidator.php';

class TelephoneBillController
{
    private $validator;

    public function __construct()
    {
        $this->validator = new TelephoneBillValidator();
    }

    /**
     * 計算電話費
     * @param string|float|int $callDuration
     * @return array [success, html]
     */
    public function calculateBill($callDuration)
    {
        $error = $this->validator->validateDuration($callDuration);
        if ($error) {
            return [
                'success' => false,
                'html' => "<p>{$error}</p>"
            ];
        }
        $callDuration = floatval($callDuration);
        if ($callDuration <= 600) {
            $billAmount = $callDuration * 0.5;
        } elseif ($callDuration <= 1200) {
            $billAmount = 600 * 0.5 + ($callDuration - 600) * 0.5 * 0.9;
        } else {
            $billAmount = 600 * 0.5 + (1200 - 600) * 0.5 * 0.9 + ($callDuration - 1200) * 0.5 * 0.79;
        }
        ob_start();
        echo "<p>通話時長: {$callDuration} 分鐘</p>";
        echo "<p>計算過程:</p>";
        echo "<ul>";
        if ($callDuration <= 600) {
            echo "<li>前 600 分鐘: " . number_format($callDuration * 0.5, 2) . " 元</li>";
        } else {
            echo "<li>前 600 分鐘: " . number_format(600 * 0.5, 2) . " 元</li>";
        }
        if ($callDuration > 600 && $callDuration <= 1200) {
            echo "<li>超過 600 未滿 1200 分鐘: " . number_format(($callDuration - 600) * 0.5 * 0.9, 2) . " 元</li>";
        } elseif ($callDuration > 1200) {
            echo "<li>超過 600 未滿 1200 分鐘: " . number_format(600 * 0.5 * 0.9, 2) . " 元</li>";
        }
        if ($callDuration > 1200) {
            echo "<li>超過 1200 分鐘以上: " . number_format(($callDuration - 1200) * 0.5 * 0.79, 2) . " 元</li>";
        }
        echo "</ul>";
        echo "<p>總金額為 NT$ " . number_format($billAmount, 2) . "</p>";
        echo "<h3>應繳金額為 NT$ " . round($billAmount) . "</h3>";
        $html = ob_get_clean();
        return [
            'success' => true,
            'html' => $html
        ];
    }
}
