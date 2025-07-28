<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;
use App\Controller\BinaryController;

HtmlHelper::renderHeader('binary', '');
?>

<header>
    <h1>計算多少個1</h1>
    <p>將 10 進位開始除 2 的遞迴，計算階層與餘數</p>
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
            $result = $controller->getBinaryStepsInfo($input);
            if ($result['success']) {
                echo "<div>計算過程：</div>";
                echo "<table border='1' cellpadding='4' style='border-collapse:collapse;'><tr><th>階層值</th><th>商數</th><th>餘數</th></tr>";
                foreach ($result['steps'] as $step) {
                    echo "<tr><td>{$step['value']}</td><td>{$step['quotient']}</td><td>{$step['remainder']}</td></tr>";
                }
                echo "</table>";
                echo "<div>餘數陣列（由上而下為二進位）：[" . implode(', ', array_reverse($result['remainders'])) . "]</div>";
                echo "<div>共有 <strong>{$result['onesCount']}</strong> 個 1</div>";
            } else {
                echo "<div style='color:red'>{$result['message']}</div>";
            }
        }
        ?>
    </section>

</main>


<?php HtmlHelper::renderFooter(); ?>