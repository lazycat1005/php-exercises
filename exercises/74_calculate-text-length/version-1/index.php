<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;
use App\Controller\TextLengthController;

HtmlHelper::renderHeader('textLength', '74textLength.css');
?>

<header>
    <h1>計算文字</h1>
    <p>版本一: 給予一個 textarea，貼上後送出用 PHP 計算有幾個字</p>
</header>

<main class="container">
    <form method="get">
        <div>
            <label for="text">請在此輸入文字:</label>
            <textarea name="text" rows="10" cols="30" placeholder="請在此輸入文字..."></textarea>
        </div>
        <button type="submit">計算字數</button>
    </form>

    <section class="result">
        <?php
        if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['text'])) {
            $controller = new TextLengthController();
            $result = $controller->calculateTextLength(trim($_GET['text']), 1000);
            echo $result['html'];
        }
        ?>
    </section>
</main>


<?php HtmlHelper::renderFooter(); ?>