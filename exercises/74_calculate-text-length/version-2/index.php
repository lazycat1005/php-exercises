<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;

HtmlHelper::renderHeader('textLength', '74textLength.css');
?>

<header>
    <h1>計算文字</h1>
    <p>版本二: 給予一個 textarea，onblur 後用 JQuery 計算 textarea 已輸入幾個字</p>
</header>

<main class="container">

    <form>
        <div><textarea name="text" placeholder="請在此輸入文字..." onblur="text74CountChars(this)"></textarea></div>
    </form>


    <section class="result">
        <p id="charCount">字元個數: 0</p>
    </section>
</main>


<?php HtmlHelper::renderFooter('74textLength.js'); ?>