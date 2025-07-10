<?php
session_start();
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;

HtmlHelper::renderHeader('numbersToChinese', '29numbersToChinese.css');
?>


<div class="container">
    <h1>轉換數字為中文單位</h1>
    <form id="numberForm" action="" method="GET">
        <fieldset>
            <label for="numberInput">請輸入數字:</label>
            <input type="number" id="numberInput" name="numberInput" max="9999999" min="0" step="1" required>
            <button type="submit">轉換</button>
        </fieldset>
    </form>

    <div id="result">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['numberInput'])) {
            // 取得使用者輸入的數字
            $number = intval($_GET['numberInput']);
            if ($number < 0 || $number > 9999999) {
                // 檢查數字範圍是否合法
                echo "<p>請輸入有效的數字 (0-9999999)。</p>";
            } else {
                // 顯示轉換結果
                echo "<p>轉換結果: " . numberToChinese($number) . "</p>";
            }
        }

        function numberToChinese($number)
        {
            // 0 直接回傳
            if ($number === 0) {
                return '零圓整';
            }

            $digits = ['零', '壹', '貳', '參', '肆', '伍', '陸', '柒', '捌', '玖'];
            $smallUnits = ['', '拾', '佰', '仟'];
            $bigUnits = ['', '萬'];

            $convertFour = function ($num) use ($digits, $smallUnits) {
                if ($num === 0) return '';

                $str = str_pad((string)$num, 4, '0', STR_PAD_LEFT); // 補成 4 位
                $result = '';
                $needZero = false; // 記錄是否要補「零」

                for ($i = 0; $i < 4; $i++) {
                    $d = intval($str[$i]);
                    if ($d === 0) {
                        $needZero = true;   // 先記住有 0，下一個非 0 再補
                    } else {
                        if ($needZero && $result !== '') {
                            $result .= '零';
                        }
                        $result .= $digits[$d] . $smallUnits[3 - $i];
                        $needZero = false;
                    }
                }
                return $result;
            };

            $wan = intdiv($number, 10000);  // 0–999
            $qian = $number % 10000;         // 0–9999

            $result = '';

            // (1) 萬段
            if ($wan) {
                $result .= $convertFour($wan) . '萬';
            }
            // (2) 千段（最後 4 位）
            if ($qian) {
                // 前面有內容且千段不足 4 位時補零
                if ($wan && $qian < 1000) $result .= '零';
                $result .= $convertFour($qian);
            }
            return $result . '圓整';
        }


        ?>
    </div>
</div>

<?php HtmlHelper::renderFooter(''); ?>