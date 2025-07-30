<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;
use App\Validator\ConstellationValidator;
use App\Controller\ConstellationService;

HtmlHelper::renderHeader('constellations', '33constellations.css');
?>

<header>
    <h1>星座與生肖</h1>
    <p>根據使用者輸入的生日，顯示對應的星座和生肖。</p>
</header>

<main class="container">
    <form id="constellation-form" method="get" action="">
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

        <?php
        // 處理表單提交
        if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['birthYear'], $_GET['birthMonth'], $_GET['birthDay'])) {
            $year = $_GET['birthYear'];
            $month = $_GET['birthMonth'];
            $day = $_GET['birthDay'];
            $eraType = $_GET['eraType'] ?? '西元';

            // 驗證輸入
            list($isValid, $errorMessage) = ConstellationValidator::validateBirthdayInput($year, $month, $day);
            if (!$isValid) {
                echo "<p class='error'>錯誤: $errorMessage</p>";
            } else {
                // 民國轉西元年齡計算
                $calcYear = $eraType === '民國' ? ((int)$year + 1911) : (int)$year;
                $constellation = ConstellationService::getConstellation((int)$month, (int)$day);
                $zodiac = ConstellationService::getZodiac((int)$year, $eraType);
                $age = ConstellationService::calculateAge($calcYear, (int)$month, (int)$day);
                echo "<p>您的生日是: <strong>$year 年 $month 月 $day 日</strong></p>";
                echo "<p>您的實際年齡是: <strong>$age 歲</strong></p>";
                echo "<p>您的星座是: <strong>$constellation</strong></p>";
                echo "<p>您的生肖是: <strong>$zodiac</strong></p>";
            }
        }
        ?>

    </section>
</main>





<?php HtmlHelper::renderFooter(); ?>