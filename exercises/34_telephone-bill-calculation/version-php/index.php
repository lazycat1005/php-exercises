<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;
use App\Controller\TelephoneBillController;

HtmlHelper::renderHeader('telephone', '34telephoneBill.css');
?>

<header>
    <h1>電話費計算器</h1>
    <p>輸入分鐘數(無法輸入小數)計算電話費</p>
</header>

<main class="container">

    <section class="introduction">
        <h2>計算規則</h2>
        <p>600 分鐘以下每分鐘 0.5 元，600~1200 分鐘電話費以 9 折計算，1200 分鐘以上電話費以 79 折計算</p>
    </section>

    <form id="telephoneBillCalculation" method="get">
        <div>
            <label for="callDuration">通話時長（分鐘）:</label>
            <input type="number" id="callDuration" name="callDuration" step="1" min="0" max="44640" required>
        </div>

        <button type="submit">計算電話費</button>
    </form>

    <section class="result" style="display:<?php echo isset($_GET['callDuration']) ? 'block' : 'none'; ?>;">
        <h2>這個月的電話帳單詳細為:</h2>
        <?php
        if (isset($_GET['callDuration'])) {
            $controller = new TelephoneBillController();
            $result = $controller->calculateBill($_GET['callDuration']);
            echo $result['html'];
        }
        ?>
    </section>
</main>

<?php HtmlHelper::renderFooter(); ?>