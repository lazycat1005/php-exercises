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
    <form class="text-length__form" method="get" action="">
        <textarea name="text" rows="10" cols="30" placeholder="請在此輸入文字..."></textarea>
        <button type="submit">計算字數</button>
    </form>

    <section class="text-length__result">
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