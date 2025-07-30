<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;

HtmlHelper::renderHeader('binary', '96binary.css');
?>

<header>
    <h1>計算多少個1</h1>
    <p>用 JS 寫，將 10 進位開始除 2 的遞迴，計算階層與餘數</p>
</header>

<main class="container">
    <form id="binaryForm2">
        <div>
            <label for="binaryInput">請輸入數字：</label>
            <input type="number" id="binaryInput" name="binaryInput" placeholder="十進位數字，如35、124、215..." min="1" max="256" step="1" required>
        </div>
        <button type="submit">計算</button>
    </form>

    <section id="resultSection"></section>
</main>

<?php HtmlHelper::renderFooter('96binary.js'); ?>