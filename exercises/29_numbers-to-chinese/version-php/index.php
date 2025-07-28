<?php
session_start();
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;
use App\Controller\NumberToChineseController;
use App\Validator\NumberToChineseValidator;

HtmlHelper::renderHeader('numbersToChinese', '29numbersToChinese.css');
?>

<header>
    <h1>數字轉中文單位</h1>
    <p>給予一個輸入框，送出後 PHP 會將數字轉換為中文單位，並顯示在頁面上。</p>
</header>

<main class="container">
    <form id="numberForm" action="" method="GET">
        <label for="numberInput">請輸入數字:</label>
        <input type="number" id="numberInput" name="numberInput" max="9999999" min="0" step="1" required>
        <button type="submit">轉換</button>
    </form>

    <section id="result">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['numberInput'])) {
            $number = $_GET['numberInput'];
            if (!NumberToChineseValidator::validate($number)) {
                echo "<p>請輸入有效的數字 (0-9999999)。</p>";
            } else {
                $number = intval($number);
                echo "<p>轉換結果: " . NumberToChineseController::convert($number) . "</p>";
            }
        }
        ?>
    </section>
</main>

<?php HtmlHelper::renderFooter(''); ?>