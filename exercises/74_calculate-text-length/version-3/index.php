<?php
require_once '../../../app/helper/HtmlHelper.php';
HtmlHelper::renderHeader('textLength', '74textLength.css');
?>


<div class="text-length__container">
    <!-- 標題 -->
    <header class="text-length__header">
        <h1>計算文字</h1>
        <p>版本三: 限制 textarea 輸入上限為 100 個字，送出後 PHP 驗證超過字數就跳警告</p>
    </header>

    <!-- 主結構 -->
    <main>
        <form class="text-length__form" method="get" action="">
            <textarea name="text" rows="10" cols="30" placeholder="請在此輸入文字..." maxlength="100"></textarea>
            <button type="submit">計算字數</button>
        </form>

        <div class="text-length__result">
            <?php
            $controllerPath = '../../../app/controller/74TextLengthController.php';

            require_once $controllerPath;
            if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['text'])) {
                $controller = new TextLengthController();
                $result = $controller->calculateTextLength($_GET['text'], 100);
                echo $result['html'];
            }
            ?>
        </div>
    </main>
</div>

<?php HtmlHelper::renderFooter(); ?>