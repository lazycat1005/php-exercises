<?php
require_once '../../../app/helper/HtmlHelper.php';
HtmlHelper::renderHeader('textLength', '74textLength.css');
?>


<div class="text-length__container">
    <!-- 標題 -->
    <header class="text-length__header">
        <h1>計算文字</h1>
        <p>版本一: 給予一個 textarea，貼上後送出用 PHP 計算有幾個字</p>
    </header>

    <!-- 主結構 -->
    <main>
        <form class="text-length__form" method="get" action="">
            <textarea name="text" rows="10" cols="30" placeholder="請在此輸入文字..."></textarea>
            <button type="submit">計算字數</button>
        </form>

        <div class="text-length__result">
            <?php
            $controllerPath = '../../../app/controller/74TextLengthController.php';

            require_once $controllerPath;
            if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['text'])) {
                $controller = new TextLengthController();
                $result = $controller->calculateTextLength(trim($_GET['text']), 1000);
                echo $result['html'];
            }

            ?>
        </div>
    </main>
</div>

<?php HtmlHelper::renderFooter('74textLength.js'); ?>