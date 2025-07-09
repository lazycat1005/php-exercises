<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;

HtmlHelper::renderHeader('temperature', '08temperature.css');
?>


<main id="ajaxVersion" class="container">
    <h1>溫度單位轉換</h1>

    <form>
        <fieldset id="temperatureConversion">
            <div class="celsius">
                <label for="celsius">攝氏溫度 (°C):</label>
                <input type="number" id="celsius" name="celsius" required>
            </div>

            <div class="fahrenheit">
                <label for="fahrenheit">華氏溫度 (°F):</label>
                <input type="number" id="fahrenheit" name="fahrenheit" required>
            </div>
        </fieldset>

        <div class="messageText">
            <p></p>
        </div>
    </form>
</main>

<?php HtmlHelper::renderFooter('08temperature.js'); ?>