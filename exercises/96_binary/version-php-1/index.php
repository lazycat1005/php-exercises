<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;
use App\Controller\BinaryController;

HtmlHelper::renderHeader('binary', '96binary.css');
?>

<header>
    <h1>計算多少個1</h1>
    <p>將 10 進位開始除 2 的遞迴，計算階層與餘數</p>
</header>

<main class="container">
    <form method="get">
        <div>
            <label for="binaryInput">請輸入數字：</label>
            <input type="number" id="binaryInput" name="binaryInput" placeholder="十進位數字，如35、124、215..." min="1" max="256" step="1" required>
        </div>
        <button type="submit">計算</button>
    </form>

    <section id="resultSection">
        <?php
        if (isset($_GET['binaryInput'])) {
            $input = $_GET['binaryInput'];
            $controller = new BinaryController();
            $result = $controller->getBinaryStepsInfo($input);
            if ($result['success']) {
                echo "<h2>計算過程：</h2>";
                echo "<table><tr><th>階層值</th><th>商數</th><th>餘數</th></tr>";
                foreach ($result['steps'] as $step) {
                    echo "<tr><td>{$step['value']}</td><td>{$step['quotient']}</td><td>{$step['remainder']}</td></tr>";
                }
                echo "</table>";
                echo "<p>餘數陣列（由上而下為二進位）：[" . implode(', ', array_reverse($result['remainders'])) . "]</p>";
                echo "<p>共有 <strong>{$result['onesCount']}</strong> 個 1</p>";
            } else {
                echo "<h3 style='color:red'>{$result['message']}</h3>";
            }
        }
        ?>
    </section>

</main>


<?php HtmlHelper::renderFooter(); ?>