<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;

HtmlHelper::renderHeader('binary', '');
?>

<main>
    <header>
        <h1>計算多少個1</h1>
        <p>將 10 進位轉 2 進位，再切割字串計算</p>
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

        // 將驗證過的數字轉換成二進位，並將轉換完的數字轉換成字串，使用字串切割的方法將字元一個個切開並計算有多個1
        function convertToBinary($number)
        {
            $binaryStr = decbin($number);
            $digits = str_split($binaryStr);
            $onesCount = 0;
            foreach ($digits as $d) {
                if ($d === '1') {
                    $onesCount++;
                }
            }
            return [
                'binaryStr' => $binaryStr,
                'onesCount' => $onesCount,
                'digits' => $digits
            ];
        }

        // 表單處理
        if (isset($_GET['binary-input'])) {
            $input = $_GET['binary-input'];
            $validation = validateInput($input);
            if ($validation === true) {
                $num = intval($input);
                $result = convertToBinary($num);
                echo "<div>二進位表示：{$result['binaryStr']}</div>";
                echo "<div>切割後陣列：[" . implode(', ', $result['digits']) . "]</div>";
                echo "<div>共有 <strong>{$result['onesCount']}</strong> 個 1</div>";
            } else {
                echo "<div style='color:red'>{$validation}</div>";
            }
        }
        ?>
    </section>

</main>


<?php HtmlHelper::renderFooter(); ?>