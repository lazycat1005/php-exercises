<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;

HtmlHelper::renderHeader('guessNumber', '53guessNumber.css');
?>

<header>
    <h1>猜數字遊戲 (1~100)</h1>
    <p>點擊 [開始] 產生隨機數字，然後猜測這個數字。你可以在猜測後點擊 [公布答案] 來查看正確答案。</p>
</header>

<main>
    <form id="gameForm" onsubmit="return false;">
        <button type="button" id="btnStart">開始</button>
        <button type="button" id="btnReveal" disabled>公布答案</button>
    </form>

    <form id="guessForm" class="input-box" onsubmit="return false;">
        <label for="guess">你的猜測：</label>
        <input type="number" id="guess" min="1" max="100" required disabled>
        <button type="button" id="btnSubmit" disabled>送出</button>
    </form>

    <section>
        <p id="message"></p>

        <div id="guessedNumbersContainer">
            <strong>已猜過的數字：</strong>
            <span id="guessedNumbers"></span>
        </div>
    </section>
</main>

<?php HtmlHelper::renderFooter('53guessNumber.js'); ?>