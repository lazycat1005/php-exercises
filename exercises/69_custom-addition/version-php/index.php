<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;

HtmlHelper::renderHeader('customAddition', '');
?>

<main>
    <header>
        <h1>自訂加法</h1>
        <p> 用 PHP 自己寫浮點數的"加法" (乘法不用)，將浮點數換為整數計算後，再補回小數點(可對照印出 PHP 內建函式 bcadd 的結果比對是否一致)</p>
    </header>

    <form id="additionForm" method="get">
        <label for="number1">第一個數字：</label>
        <input type="number" id="number1" name="number1" required step="any">

        <label for="number2">第二個數字：</label>
        <input type="number" id="number2" name="number2" required step="any">

        <button type="submit">計算和</button>
    </form>

    <div id="result">

        <?php
        //寫一個驗證使用者輸入的函數，驗證使用者所輸入的兩個資料只能是數字或浮點數，不能為字元或含有科學符號(如:1e2)
        function validateInput($input1, $input2)
        {
            // 檢查是否為數字或浮點數
            if (!is_numeric($input1) || !is_numeric($input2)) {
                return false; // 如果不是數字或浮點數，返回 false
            }
            // 檢查是否含有科學記號
            if (preg_match('/[eE]/', $input1) || preg_match('/[eE]/', $input2)) {
                return false; // 如果含有科學記號，返回 false
            }

            return true; // 驗證通過
        }

        //將經validateInput()驗證過後的兩個數字轉為字串並分析每個數字的小數位數
        function convertToString($input1, $input2)
        {
            $str1 = (string)$input1;
            $str2 = (string)$input2;

            $decimalPlaces1 = strpos($str1, '.') !== false ? strlen(substr($str1, strpos($str1, '.') + 1)) : 0; //如果帶入12345則結果為 0
            $decimalPlaces2 = strpos($str2, '.') !== false ? strlen(substr($str2, strpos($str2, '.') + 1)) : 0; //如果帶入0.1則結果為 1

            return [$str1, $str2, $decimalPlaces1, $decimalPlaces2];
        }

        //比較$decimalPlaces1和$decimalPlaces2的位數，找出最大位數n，並將$input1和$input2各自乘以10^n
        function adjustForDecimalPlaces($str1, $str2, $decimalPlaces1, $decimalPlaces2)
        {
            $maxDecimalPlaces = max($decimalPlaces1, $decimalPlaces2);

            $adjusted1 = (int)str_replace('.', '', str_pad($str1, $maxDecimalPlaces + strlen($str1) - strpos($str1, '.') - 1, '0', STR_PAD_RIGHT)); //$str1可能是"123.45"，則$adjusted1會變成"12345"
            $adjusted2 = (int)str_replace('.', '', str_pad($str2, $maxDecimalPlaces + strlen($str2) - strpos($str2, '.') - 1, '0', STR_PAD_RIGHT)); // $str2可能是"0.1"，則$adjusted2會變成"10"

            return [$adjusted1, $adjusted2, $maxDecimalPlaces];
        }

        //計算兩個整數的和，然後將結果除以10^n，並將小數點補回去
        function calculateSum($adjusted1, $adjusted2, $maxDecimalPlaces)
        {
            $sum = $adjusted1 + $adjusted2;
            $result = $sum / pow(10, $maxDecimalPlaces); //如果$sun是"12345"和"10"的和，則結果為"12355"，然後除以10^2(即100)，結果為"123.55"

            return number_format($result, $maxDecimalPlaces, '.', '');
        }

        // 將計算的結果與php的bcadd()函數的結果進行"==="比對，並輸出true或false
        function compareWithBcadd($originalStr1, $originalStr2, $adjusted1, $adjusted2, $maxDecimalPlaces)
        {
            $bcResult = bcadd($originalStr1, $originalStr2, $maxDecimalPlaces);
            $calculatedResult = calculateSum($adjusted1, $adjusted2, $maxDecimalPlaces);
            return $bcResult === $calculatedResult ? 'true' : 'false';
        }

        //處理表單提交
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['number1']) && isset($_GET['number2'])) {
            $number1 = $_GET['number1'];
            $number2 = $_GET['number2'];

            if (validateInput($number1, $number2)) {
                list($str1, $str2, $decimalPlaces1, $decimalPlaces2) = convertToString($number1, $number2);
                list($adjusted1, $adjusted2, $maxDecimalPlaces) = adjustForDecimalPlaces($str1, $str2, $decimalPlaces1, $decimalPlaces2);
                $result = calculateSum($adjusted1, $adjusted2, $maxDecimalPlaces);

                echo "<p>計算結果: {$result}</p>";

                //印出與PHP內建函式bcadd的結果比對
                $comparisonResult = compareWithBcadd($str1, $str2, $adjusted1, $adjusted2, $maxDecimalPlaces);

                echo "<p>與 PHP 的 bcadd() 函數結果比對: {$comparisonResult}</p>";
            } else {
                echo "<p>請輸入有效的數字。</p>";
            }
        }

        ?>

    </div>
</main>




<?php HtmlHelper::renderFooter(); ?>