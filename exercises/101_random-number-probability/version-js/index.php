<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;

HtmlHelper::renderHeader('randomNumberProbability', '');
?>


<main>
    <header>
        <h1>取得某兩數(含)間的亂數值，須限制數字位數</h1>
        <p>用 PHP 與 JS 取得亂數值某兩數(含)間，且可指定取得間隔 (例如1、0.01、0.1)，若未指定間隔就是看兩數的小數位數誰小且寫完後用 for 迴圈執行1萬次，印出測試機率資料，驗證機率有平均出現</p>
    </header>

    <form method="get">
        <label for="min">最小值:</label>
        <input type="number" id="min" name="min" step="any"
            required>
        <label for="max">最大值:</label>
        <input type="number" id="max" name="max" step="any"
            required>
        <label for="step">間隔:</label>
        <select name="step" id="step">
            <option value="不指定">不指定</option>
            <option value="1">1</option>
            <option value="0.01">0.01</option>
            <option value="0.1">0.1</option>
        </select>

        <button type="submit">取得亂數</button>
    </form>

    <section>
        <h2>結果</h2>
        <div id="result"></div>
    </section>
</main>


<?php HtmlHelper::renderFooter("101randomNumberProbability.js"); ?>