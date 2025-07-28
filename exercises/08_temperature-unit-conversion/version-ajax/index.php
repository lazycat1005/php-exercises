<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;

HtmlHelper::renderHeader('temperature', '08temperature.css');

// 取得網站根目錄路徑，供 JavaScript 使用
$webRoot = HtmlHelper::getWebRoot();
?>

<script>
    // 設定全域變數供 AJAX 使用
    window.webRoot = '<?php echo htmlspecialchars($webRoot); ?>';
</script>

<header>
    <h1>溫度單位轉換</h1>
    <p>請輸入攝氏或華氏溫度，系統將自動轉換並顯示結果。</p>
</header>

<main id="ajaxVersion" class="container">
    <form>
        <div class="celsius">
            <label for="celsius">攝氏溫度 (°C):</label>
            <input type="number" id="celsius" name="celsius" required>
        </div>

        <div class="fahrenheit">
            <label for="fahrenheit">華氏溫度 (°F):</label>
            <input type="number" id="fahrenheit" name="fahrenheit" required>
        </div>
    </form>

    <section class="resultSection">
        <p class="messageText"></p>
    </section>
</main>

<?php HtmlHelper::renderFooter('08temperatureAjax.js'); ?>