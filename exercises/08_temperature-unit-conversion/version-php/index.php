<?php
// 顯示所有錯誤，方便除錯
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

$metaKey = "temperature";
$exerciseDir = __DIR__ . '/../';
include '../../../header.php';
?>

<body>
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
            require_once '../utils/Validator.php';
            $validator = new Validator();

            // 檢查是否有 GET 資料
            if (!empty($_GET)) {
                $convert = $_GET['convert'] ?? null;
                $celsius = $_GET['celsius'] ?? '';
                $fahrenheit = $_GET['fahrenheit'] ?? '';

                $hasCelsius = $celsius !== '';
                $hasFahrenheit = $fahrenheit !== '';

                // 同時輸入兩個欄位
                if ($hasCelsius && $hasFahrenheit) {
                    echo "<p>請只填一個欄位，不能兩個都填。</p>";
                }
                // 兩個欄位都沒填
                elseif (!$hasCelsius && !$hasFahrenheit) {
                    echo "<p>請輸入一個溫度值。</p>";
                } else {
                    // 攝氏轉華氏
                    if ($convert === 'toFahrenheit') {
                        $error = $validator->validateTemperature($celsius, '攝氏');
                        if ($error !== '') {
                            echo "<p>{$error}</p>";
                        } else {
                            $c = floatval($celsius);
                            $f = round(($c * 9 / 5) + 32, 2);
                            echo "<p>攝氏 {$c}°C 等於華氏 {$f}°F</p>";
                        }
                    }
                    // 華氏轉攝氏
                    elseif ($convert === 'toCelsius') {
                        $error = $validator->validateTemperature($fahrenheit, '華氏');
                        if ($error !== '') {
                            echo "<p>{$error}</p>";
                        } else {
                            $f = floatval($fahrenheit);
                            $c = round(($f - 32) * 5 / 9, 2);
                            echo "<p>華氏 {$f}°F 等於攝氏 {$c}°C</p>";
                        }
                    }
                    // 未選擇轉換方向
                    else {
                        echo "<p>請選擇轉換方向。</p>";
                    }
                }
            }
            ?>
        </div>
    </div>

    <a class="fixedBtn" href="../../../index.php">Back</a>

    <script src="./app.js"></script>
</body>

</html>