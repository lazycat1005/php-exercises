<?php
session_start();
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;
use App\Controller\NumberToChineseController;
use App\Validator\NumberToChineseValidator;

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
            $number = $_GET['numberInput'];
            if (!NumberToChineseValidator::validate($number)) {
                echo "<p>請輸入有效的數字 (0-9999999)。</p>";
            } else {
                $number = intval($number);
                echo "<p>轉換結果: " . NumberToChineseController::convert($number) . "</p>";
            }
        }
        ?>
    </div>
</div>

<?php HtmlHelper::renderFooter(''); ?>