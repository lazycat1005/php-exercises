<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;

HtmlHelper::renderHeader('telephone', '34telephoneBill.css');
?>


<main id="jsVersion" class="container">
    <section class="introduction">
        <h1>電話費計算器</h1>
        <ul>
            <li>600 分鐘以下每分鐘 0.5 元</li>
            <li>600~1200 分鐘電話費以 9 折計算</li>
            <li>1200 分鐘以上電話費以 79 折計算</li>
            <li>可統計最新的12期帳單總金額</li>
        </ul>
    </section>

    <form>
        <fieldset id="telephoneBillCalculation">
            <label for="callDuration">通話時長（分鐘）:</label>
            <input type="number" id="callDuration" name="callDuration" step="any" min="0" max="44640" required>

            <button type="submit">計算電話費</button>
        </fieldset>
    </form>

    <section class="result">
        <h2>這個月的應繳金額為:<span></span></h2>
        <h3></h3>
        <h4></h4>

    </section>
</main>

<?php HtmlHelper::renderFooter('34telephoneBill.js'); ?>