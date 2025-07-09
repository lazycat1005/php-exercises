<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;
use App\Controller\TemperatureController;

HtmlHelper::renderHeader('temperature', '08temperature.css');

// 新增：條件式引入控制器

$controller = new TemperatureController();


?>


<div id="phpVersion" class="container">
    <h1>溫度單位轉換</h1>

    <form action="" method="get">
        <fieldset id="temperatureConversion">
            <div class="celsius">
                <label for="celsius">攝氏溫度 (°C):</label>
                <input type="number" name="celsius" step="any">
            </div>

            <div class="buttons">
                <button type="submit" name="convert" value="toCelsius">← 轉換成攝氏</button>
                <button type="button" id="clearBtn">清除</button>
                <button type="submit" name="convert" value="toFahrenheit">轉換成華氏 →</button>
            </div>

            <div class="fahrenheit">
                <label for="fahrenheit">華氏溫度 (°F):</label>
                <input type="number" name="fahrenheit" step="any">
            </div>
        </fieldset>
    </form>

    <div class="messageText">
        <?php
        // 檢查是否有 GET 資料
        if (!empty($_GET)) {
            $convert = $_GET['convert'] ?? null;
            $celsius = $_GET['celsius'] ?? '';
            $fahrenheit = $_GET['fahrenheit'] ?? '';

            $hasCelsius = $celsius !== '';
            $hasFahrenheit = $fahrenheit !== '';

            if ($hasCelsius && $hasFahrenheit) {
                echo "<p>請只填一個欄位，不能兩個都填。</p>";
            } elseif (!$hasCelsius && !$hasFahrenheit) {
                echo "<p>請輸入一個溫度值。</p>";
            } else {
                if ($convert === 'toFahrenheit') {
                    $result = $controller->convertTemperature($celsius, 'C', 'F', '攝氏');
                    if ($result['success']) {
                        $c = floatval($celsius);
                        $f = round($result['result'], 2);
                        echo "<p>攝氏 {$c}°C 等於華氏 {$f}°F</p>";
                    } else {
                        echo "<p>{$result['message']}</p>";
                    }
                } elseif ($convert === 'toCelsius') {
                    $result = $controller->convertTemperature($fahrenheit, 'F', 'C', '華氏');
                    if ($result['success']) {
                        $f = floatval($fahrenheit);
                        $c = round($result['result'], 2);
                        echo "<p>華氏 {$f}°F 等於攝氏 {$c}°C</p>";
                    } else {
                        echo "<p>{$result['message']}</p>";
                    }
                } else {
                    echo "<p>請選擇轉換方向。</p>";
                }
            }
        }
        ?>
    </div>
</div>

<?php HtmlHelper::renderFooter('08temperature.js'); ?>