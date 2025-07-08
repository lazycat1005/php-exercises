<?php
require_once '../../../app/helper/HtmlHelper.php';
HtmlHelper::renderHeader('textLength', '74textLength.css');
?>

<div class="text-length__container">
    <!-- 標題 -->
    <header class="text-length__header">
        <h1>計算文字</h1>
        <p>版本四: 限制 textarea 輸入上限為 100 個字，輸入當下就用 JS 計算 textarea 已輸入幾個字，並且超過字數就不給輸入任何文字</p>
    </header>

    <!-- 主結構 -->
    <main>
        <form class="text-length__form" method="get" action="">
            <textarea id="version4" name="text" rows="10" cols="30" placeholder="請在此輸入文字..." maxlength="100"></textarea>
        </form>

        <div class="text-length__result">
            <p id="charCount">字元個數: 0</p>
        </div>
    </main>
</div>

<?php HtmlHelper::renderFooter('74textLength.js'); ?>