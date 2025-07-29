<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;
use App\Controller\BinaryController;

HtmlHelper::renderHeader('binary', '96binary.css');
?>

<header>
    <h1>計算多少個1</h1>
    <p>將 10 進位轉 2 進位，再切割字串計算</p>
</header>

<main class="container">
    <form method="get">
        <label for="binaryInput">請輸入數字：</label>
        <input type="number" id="binaryInput" name="binaryInput" placeholder="十進位數字，如35、124、215..." min="1" max="256" step="1" required>
        <button type="submit">計算</button>
    </form>

    <section id="resultSection">
        <?php
        if (isset($_GET['binaryInput'])) {
            $input = $_GET['binaryInput'];
            $controller = new BinaryController();
            $result = $controller->getBinaryStringInfo($input);
            if ($result['success']) {

                echo "<h2>二進位表示：{$result['binaryStr']}</h2>";
                echo "<h3>切割後陣列：[" . implode(', ', $result['digits']) . "]</h3>";
                echo "<p>共有 <strong>{$result['onesCount']}</strong> 個 1</p>";
            } else {
                echo "<h3 style='color:red'>{$result['message']}</h3>";
            }
        }
        ?>
    </section>

</main>


<?php HtmlHelper::renderFooter(); ?>