<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;

HtmlHelper::renderHeader('constellations', '33constellations.css');
?>

<header>
    <h1>星座與生肖</h1>
    <p>根據使用者輸入的生日，顯示對應的星座和生肖。</p>
</header>

<main class="container">
    <form id="constellationForm">
        <div>
            <label for="eraType">請選擇紀元方式:</label>
            <select name="eraType" id="eraType">
                <option value="西元">西元</option>
                <option value="民國">民國</option>
            </select>
        </div>

        <div>
            <label for="birthYear">請輸入您的生日年分:</label>
            <input type="text" id="birthYear" name="birthYear" placeholder="例如：1990 或 79">
        </div>

        <div>
            <label for="birthMonth">請輸入您的出生月份:</label>
            <input type="number" id="birthMonth" name="birthMonth" min="1" max="12" step="1" placeholder="1-12">
        </div>

        <div>
            <label for="birthDay">請輸入您的出生日期:</label>
            <input type="number" id="birthDay" name="birthDay" min="1" max="31" step="1" placeholder="1-31">
        </div>

        <button type="submit">查詢星座與生肖</button>
    </form>

    <section>
        <div id="result"></div>
    </section>
</main>

<?php HtmlHelper::renderFooter("33constellations.js"); ?>