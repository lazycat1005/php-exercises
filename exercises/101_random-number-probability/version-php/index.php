<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;

HtmlHelper::renderHeader('randomNumberProbability', '');
?>

<header>
    <h1>取得某兩數(含)間的亂數值，須限制數字位數</h1>
    <p>用 PHP 與 JS 取得亂數值某兩數(含)間，且可指定取得間隔 (例如1、0.01、0.1)，若未指定間隔就是看兩數的小數位數誰小且寫完後用 for 迴圈執行1萬次，印出測試機率資料，驗證機率有平均出現</p>
</header>

<main>
    <form method="get">
        <label for="min">最小值:</label>
        <input type="number" id="min" name="min" step="any"
            required>
        <label for="max">最大值:</label>
        <input type="number" id="max" name="max" step="any"
            required>
        <label for="step">間隔:</label>
        <select name="step" id="step">
            <option value="不指定">不指定</option>
            <option value="1">1</option>
            <option value="0.01">0.01</option>
            <option value="0.1">0.1</option>
        </select>

        <button type="submit">取得亂數</button>
    </form>

    <section>
        <h2>結果</h2>
        <?php
        //建立驗證的function，驗證使用者輸入的兩個數值有效的值，規則是不可為字元或含有字串、科學記號(如1e6)
        function validateInput($min, $max)
        {
            if (!is_numeric($min) || !is_numeric($max)) {
                return false;
            }
            if (strpos($min, 'e') !== false || strpos($max, 'e') !== false) {
                return false;
            }
            //追加驗證，確保數值不為空
            if (empty($min) || empty($max)) {
                return false;
            }
            //追加驗證，最小值不應該大於最大值
            if ($min > $max) {
                return false;
            }

            return true;
        }

        //建立一個function，將驗證過的兩個數值轉為字串，並分析兩數值的小數點位數，並回傳小數點位數
        function getDecimalPlaces($min, $max)
        {
            $minStr = (string)$min;
            $maxStr = (string)$max;

            $minDecimal = strpos($minStr, '.') !== false ? strlen(substr($minStr, strpos($minStr, '.') + 1)) : 0;
            $maxDecimal = strpos($maxStr, '.') !== false ? strlen(substr($maxStr, strpos($maxStr, '.') + 1)) : 0;

            return max($minDecimal, $maxDecimal);
        }

        //建立一個function，取得間隔數值，如果使用者選擇不指定間隔，則使用兩數的小數位數計算間隔，規則是取位數大者，例如第一個數為2.4小數位為1，第二個數為3.69，小數位為2，則取小數位大者2，並設定間隔為0.01，若使用者有選擇，則用使用者的選擇
        function getStep($step, $min, $max)
        {
            if ($step === '不指定' || $step === '' || $step === null) {
                // 自動判斷小數精度
                $decimalPlaces = getDecimalPlaces($min, $max);
                return pow(10, -$decimalPlaces); // e.g. 0.01
            }

            // 強制轉 float
            $stepFloat = floatval($step);

            // 預防無效或0值
            if ($stepFloat <= 0) {
                $decimalPlaces = getDecimalPlaces($min, $max);
                return pow(10, -$decimalPlaces);
            }

            return $stepFloat;
        }

        //建立一個function，使用迴圈跑10000次，亂數的最大值與最小值是使用者輸入的兩個數值，間隔是使用者選擇的間隔，並且印出每次迴圈的亂數值並統計出現次數
        function getRandomNumber($min, $max, $step)
        {
            $count = 10000; // 執行亂數產生的次數
            $results = [];  // 用來統計每個亂數值出現的次數
            $step = getStep($step, $min, $max); // 取得正確的間隔值

            // 計算 min/max 與 step 的小數位數，取最大值，確保亂數值精度正確
            $decimalPlacesMinMax = getDecimalPlaces($min, $max);
            $stepStr = (string)$step;
            $decimalPlacesStep = strpos($stepStr, '.') !== false
                ? strlen(substr($stepStr, strpos($stepStr, '.') + 1))
                : 0;
            $decimalPlaces = max($decimalPlacesMinMax, $decimalPlacesStep);

            // 進行 $count 次亂數產生與統計
            for ($i = 0; $i < $count; $i++) {
                // 將 min/max 依照 step 轉為整數範圍，方便用 mt_rand 產生亂數
                $start = (int) round($min / $step);
                $end = (int) round($max / $step);
                $randInt = mt_rand($start, $end); // 產生整數亂數
                // 轉回原本的數值範圍，並依照小數位數四捨五入
                $randomValue = round($randInt * $step, $decimalPlaces);
                // 格式化亂數值為字串（避免浮點誤差），作為陣列 key
                $key = number_format($randomValue, $decimalPlaces, '.', '');
                // 統計該亂數值出現次數
                $results[$key] = ($results[$key] ?? 0) + 1;
            }

            return $results; // 回傳每個亂數值的出現次數
        }

        //處理表單
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['min']) && isset($_GET['max']) && isset($_GET['step'])) {
            $min = $_GET['min'];
            $max = $_GET['max'];
            $step = $_GET['step'];

            //驗證輸入
            if (validateInput($min, $max)) {
                //取得亂數值
                $results = getRandomNumber($min, $max, $step);

                //印出結果
                echo "<table>";
                echo "<tr><th>亂數值</th><th>出現次數</th></tr>";
                foreach ($results as $value => $count) {
                    if ($count === 0) {
                        continue;
                    }   // 過濾空桶
                    echo "<tr><td>{$value}</td><td>{$count}</td></tr>";
                }
                echo "</table>";
            } else {
                echo "<p style='color: red;'>請輸入有效的數字，且最小值應小於最大值。</p>";
            }
        }

        ?>

    </section>
</main>

<?php HtmlHelper::renderFooter(); ?>