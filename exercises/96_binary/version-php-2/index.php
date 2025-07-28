<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;
use App\Controller\BinaryController;

HtmlHelper::renderHeader('binary', '');
?>

<header>
    <h1>計算多少個1</h1>
    <p>將 10 進位轉 2 進位，再切割字串計算</p>
</header>

<main>
    <form method="get">
        <label for="binary-input">請輸入數字：</label>
        <input type="number" id="binary-input" name="binary-input" placeholder="十進位數字，如35、124、215..." min="1" max="256" step="1" required>
        <button type="submit">計算</button>
    </form>

    <section id="result">
        <?php
        if (isset($_GET['binary-input'])) {
            $input = $_GET['binary-input'];
            $controller = new BinaryController();
            $result = $controller->getBinaryStringInfo($input);
            if ($result['success']) {
                echo "<div>二進位表示：{$result['binaryStr']}</div>";
                echo "<div>切割後陣列：[" . implode(', ', $result['digits']) . "]</div>";
                echo "<div>共有 <strong>{$result['onesCount']}</strong> 個 1</div>";
            } else {
                echo "<div style='color:red'>{$result['message']}</div>";
            }
        }
        ?>
    </section>

</main>


<?php HtmlHelper::renderFooter(); ?>