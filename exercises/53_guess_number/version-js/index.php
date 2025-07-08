<?php
require_once '../../../app/helper/HtmlHelper.php';
HtmlHelper::renderHeader('guessNumber', '53guessNumber.css');
?>


<h1>猜數字遊戲 (1~100)</h1>

<form id="gameForm" onsubmit="return false;">
    <button type="button" id="btnStart">開始</button>
    <button type="button" id="btnReveal" disabled>公布答案</button>
</form>

<div class="input-box">
    <form id="guessForm" onsubmit="return false;">
        <label for="guess">你的猜測：</label>
        <input type="number" id="guess" min="1" max="100" required disabled>
        <button type="button" id="btnSubmit" disabled>送出</button>
    </form>
</div>

<p id="message"></p>

<div id="guessedNumbersContainer">
    <strong>已猜過的數字：</strong>
    <span id="guessedNumbers"></span>
</div>

<?php
$jsFileName = '53guessNumber.js';
include '../../../footer.php';
?>