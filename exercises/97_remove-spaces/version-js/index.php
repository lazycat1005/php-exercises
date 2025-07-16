<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;

HtmlHelper::renderHeader('removeSpaces', '97removeSpaces.css');
?>


<div class="remove-spaces">
    <header class="remove-spaces__header">
        <h1>移除字串中的空格</h1>
        <p>給予一個輸入框，onblur 後用 JQuery 清除字串裡所有的空格，然後取代原本輸入框內的值，並提示"字串已更動"</p>
    </header>

    <main class="remove-spaces__main">
        <form id="inputForm">
            <label for="inputString">請輸入字串：</label>
            <input type="text" id="inputString" name="inputString" required>
        </form>
        <p id="message"></p>
    </main>
</div>


<?php HtmlHelper::renderFooter('97removeSpaces.js'); ?>