<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;

HtmlHelper::renderHeader('customAddition', '69customAddition.css');
?>

<main>
    <header>
        <h1>自訂加法</h1>
        <p> 用 JS 自己寫浮點數的"加法" (乘法不用)，將浮點數換為整數計算後，再補回小數點(可對照印出 JS 的 .toFixed 的結果比對是否一致)</p>
    </header>

    <form id="additionForm" class="addition-form">
        <label for="number1">第一個數字：</label>
        <input type="number" id="number1" name="number1" required step="any">

        <label for="number2">第二個數字：</label>
        <input type="number" id="number2" name="number2" required step="any">

        <button type="submit">計算和</button>
    </form>

    <div id="result"></div>

</main>


<?php HtmlHelper::renderFooter('69customAddition.js'); ?>