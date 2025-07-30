<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;
use App\Controller\LeapYearController;
use App\Validator\LeapYearValidator;

HtmlHelper::renderHeader('leapYears', '27leapYear.css');
?>

<header>
    <h1>閏年計算器</h1>
    <p>請輸入年份，系統將計算該年是否為閏年及其總天數。</p>
</header>

<main id="phpVersion" class="container">
    <form method="GET">
        <div>
            <label for="year">請輸入年份:</label>
            <input type="number" id="year" name="year" min="1" max="3000" step="1" required>
        </div>
        <button type="submit">計算是否為閏年</button>
    </form>

    <section>
        <?php
        if (isset($_GET['year'])) {
            $year = $_GET['year'];
            $validator = new LeapYearValidator();
            if (!$validator->validateYear($year)) {
                echo '<section class="result">';
                echo '<h2>結果:</h2>';
                echo '<p>' . htmlspecialchars($validator->getErrorMessage($year)) . '</p>';
                echo '</section>';
            } else {
                $controller = new LeapYearController();
                $result = $controller->calculateLeapYear($year);
                echo '<section class="result">';
                echo '<h2>結果:</h2>';
                echo '<p>年份: ' . htmlspecialchars($result['year']) . '</p>';
                echo '<p>總天數: ' . htmlspecialchars($result['days']) . ' 天</p>';
                echo '<p>是否為閏年: ' . ($result['isLeap'] ? '是' : '否') . '</p>';
                echo '</section>';
            }
        }
        ?>
    </section>
</main>

<?php HtmlHelper::renderFooter(); ?>