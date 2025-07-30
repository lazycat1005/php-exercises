<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;

HtmlHelper::renderHeader('removeSpaces', '97removeSpaces.css');
?>

<header>
    <h1>移除字串中的空格</h1>
    <p>給予一個輸入框，onblur 後用 JQuery 清除字串裡所有的空格，然後取代原本輸入框內的值，並提示"字串已更動"</p>
</header>

<main class="container">
    <form id="inputForm">
        <div>
            <label for="inputString">請輸入字串：</label>
            <input type="text" id="inputString" name="inputString" required>
        </div>
    </form>

    <section class="resultSection">
        <p id="message"></p>
    </section>
</main>

<?php HtmlHelper::renderFooter('97removeSpaces.js'); ?>