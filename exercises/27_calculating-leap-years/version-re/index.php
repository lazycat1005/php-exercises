<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;

HtmlHelper::renderHeader('leapYears', '');
?>

<header>
    <h1>閏年計算器</h1>
    <p>請輸入年份以檢查是否為閏年</p>
</header>

main>
<section>
    <form method="get">
        <label for="year">請輸入年份:</label>
        <input type="number" id="year" name="year" min="1" max="3000" step="1" required />
        <button type="submit">計算是否為閏年</button>
    </form>
</section>

<section class="result">
    <?php

    //處理驗證邏輯(使用正則表達式)，只接受1~3000的整數，浮點數與科學記號、字串皆不可輸入
    function isLeapYear($year)
    {
        if (!preg_match('/^\d{1,4}$/', $year) || $year < 1 || $year > 3000) {
            return '請輸入有效的年份（1~3000）';
        }
    }

    // 檢查閏年邏輯
    function checkLeapYear()
    {
        if (isset($_GET['year'])) {
            $year = $_GET['year'];
            $result = isLeapYear($year);
            echo "<p>$result</p>";
        }
    }

    // 處理表單提交的function與印出結果
    function handleFormSubmission()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['year'])) {
            $year = $_GET['year'];
            $result = isLeapYear($year);
            if ($result === null) {
                if (($year % 4 == 0 && $year % 100 != 0) || ($year % 400 == 0)) {
                    echo "<p>$year 是閏年</p>";
                } else {
                    echo "<p>$year 不是閏年</p>";
                }
            } else {
                echo "<p>$result</p>";
            }
        }
    }

    ?>


</section>

<?php HtmlHelper::renderFooter(); ?>