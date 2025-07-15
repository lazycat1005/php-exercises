<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;

HtmlHelper::renderHeader('binary', '');
?>

<main>
    <header>
        <h1>計算多少個1</h1>
        <p>將 10 進位開始除 2 的遞迴，計算階層與餘數</p>
    </header>

    <form id="binary-form">
        <label for="binary-input">請輸入數字：</label>
        <input type="number" id="binary-input" name="binary-input" placeholder="十進位數字，如35、124、215..." min="1" max="256" step="1" required>
        <button type="submit">計算</button>
    </form>

    <section id="result"></section>
</main>

<script src="/assets/js/jquery-1.12.4.min.js"></script>


<?php HtmlHelper::renderFooter(); ?>