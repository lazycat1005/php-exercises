<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;

HtmlHelper::renderHeader('binary', '');
?>

<main>
    <header>
        <h1>計算多少個1</h1>
        <p>將 10 進位開始除 2 的遞迴，計算階層與餘數</p>
    </header>

    <form method="get">
        <label for="binary-input">請輸入數字：</label>
        <input type="number" id="binary-input" name="binary-input" placeholder="十進位數字，如35、124、215..." min="1" max="256" step="1" required>
        <button type="submit">計算</button>
    </form>

    <section id="result">
        <?php
        // 驗證使用者輸入的函數，只能為正整數，且範圍為1~256，不能有小數點、科學符號、負數與字串
        function validateInput($input)
        {
            if ($input === null || $input === '' || trim($input) === '') {
                return '輸入不能為空值';
            }
            // 必須是純數字且不含小數點
            if (!preg_match('/^\d+$/', $input)) {
                return '請輸入正整數（不可有小數點、符號或字母）';
            }
            $num = intval($input);
            if ($num < 1 || $num > 256) {
                return '數字必須介於 1 到 256 之間';
            }
            return true;
        }

        // 將數字進行2的遞迴除法，回傳每一步的階層與餘數
        function getBinarySteps($number)
        {
            $steps = [];
            while ($number > 0) {
                $quotient = intdiv($number, 2);
                $remainder = $number % 2;
                $steps[] = [
                    'value' => $number,
                    'quotient' => $quotient,
                    'remainder' => $remainder
                ];
                $number = $quotient;
            }
            return $steps;
        }

        // 計算餘數陣列中有多少個1，並回傳陣列與1的數量
        function countOnesInBinarySteps($steps)
        {
            $remainders = array_column($steps, 'remainder');
            $onesCount = 0;
            foreach ($remainders as $r) {
                if ($r === 1) {
                    $onesCount++;
                }
            }
            return [
                'remainders' => $remainders,
                'onesCount' => $onesCount
            ];
        }

        // 處理表單提交
        if (isset($_GET['binary-input'])) {
            $input = $_GET['binary-input'];
            $validation = validateInput($input);
            if ($validation === true) {
                $num = intval($input);
                $steps = getBinarySteps($num);
                $binaryInfo = countOnesInBinarySteps($steps);
                echo "<div>計算過程：</div>";
                echo "<table border='1' cellpadding='4' style='border-collapse:collapse;'><tr><th>階層值</th><th>商數</th><th>餘數</th></tr>";
                foreach ($steps as $step) {
                    echo "<tr><td>{$step['value']}</td><td>{$step['quotient']}</td><td>{$step['remainder']}</td></tr>";
                }
                echo "</table>";
                // 餘數順序需反轉，才是正確的二進位由高位到低位
                echo "<div>餘數陣列（由上而下為二進位）：[" . implode(', ', array_reverse($binaryInfo['remainders'])) . "]</div>";
                echo "<div>共有 <strong>{$binaryInfo['onesCount']}</strong> 個 1</div>";
            } else {
                echo "<div style='color:red'>{$validation}</div>";
            }
        }
        ?>
    </section>

</main>


<?php HtmlHelper::renderFooter(); ?>