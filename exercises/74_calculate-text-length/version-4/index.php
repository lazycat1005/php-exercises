<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;

HtmlHelper::renderHeader('textLength', '74textLength.css');
?>

<header class="text-length__header">
    <h1>計算文字</h1>
    <p>版本四: 限制 textarea 輸入上限為 100 個字，輸入當下就用 JS 計算 textarea 已輸入幾個字，並且超過字數就不給輸入任何文字</p>
</header>

<main>
    <form class="text-length__form" method="get" action="">
        <textarea id="version4" name="text" placeholder="請在此輸入文字..." maxlength="100"></textarea>
    </form>

    <section class="text-length__result">
        <p id="charCount">字元個數: 0</p>
    </section>
</main>

<?php HtmlHelper::renderFooter('74textLength.js'); ?>