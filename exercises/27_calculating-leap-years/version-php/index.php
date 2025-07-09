<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;
use App\Controller\LeapYearController;

HtmlHelper::renderHeader('leapYears', '27leapYear.css');
?>


<main id="phpVersion" class="container">
    <h1>閏年計算器</h1>

    <form action="" method="GET">
        <fieldset id="leapYearCalculation">
            <label for="year">請輸入年份:</label>
            <input type="number" id="year" name="year" min="1" max="3000" step="1" required>
            <button type="submit">計算是否為閏年</button>
        </fieldset>
    </form>

    <section class="result">
        <h2>結果:</h2>
        <?php
        if (isset($_GET['year'])) {
            $controller = new LeapYearController();
            $result = $controller->calculateLeapYear($_GET['year']);
            echo $result['html'];
        }
        ?>
    </section>
</main>

<?php HtmlHelper::renderFooter(); ?>