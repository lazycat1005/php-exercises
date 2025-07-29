<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;
use App\Controller\TextLengthController;

HtmlHelper::renderHeader('textLength', '74textLength.css');
?>



<header>
    <h1>計算文字</h1>
    <p>版本三: 限制 textarea 輸入上限為 100 個字，送出後 PHP 驗證超過字數就跳警告</p>
</header>


<main class="container">
    <form class="text-length__form" method="get" action="">
        <textarea name="text" placeholder="請在此輸入文字..." maxlength="100"></textarea>
        <button type="submit">計算字數</button>
    </form>

    <section class="text-length__result">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['text'])) {
            $controller = new TextLengthController();
            $result = $controller->calculateTextLength($_GET['text'], 100);
            echo $result['html'];
        }
        ?>
    </section>
</main>


<?php HtmlHelper::renderFooter(); ?>