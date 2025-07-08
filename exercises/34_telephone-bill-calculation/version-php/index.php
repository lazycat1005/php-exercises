<?php
require_once '../../../app/helper/HtmlHelper.php';
HtmlHelper::renderHeader('telephone', '34telephoneBill.css');
?>

<main id="phpVersion" class="container">
    <section class="introduction">
        <h1>電話費計算器</h1>
        <ul>
            <li>600 分鐘以下每分鐘 0.5 元</li>
            <li>600~1200 分鐘電話費以 9 折計算</li>
            <li>1200 分鐘以上電話費以 79 折計算</li>
        </ul>
    </section>

    <form action="" method="get">
        <fieldset id="telephoneBillCalculation">
            <label for="callDuration">通話時長（分鐘）:</label>
            <input type="number" id="callDuration" name="callDuration" step="any" min="0" max="44640" required>

            <button type="submit">計算電話費</button>
        </fieldset>
    </form>

    <section class="result">
        <h2>這個月的電話帳單詳細為:</h2>
        <?php
        $controllerPath = '../../../app/controller/34TelephoneBillController.php';

        require_once $controllerPath;
        if (isset($_GET['callDuration'])) {
            $controller = new TelephoneBillController();
            $result = $controller->calculateBill($_GET['callDuration']);
            echo $result['html'];
        }

        ?>
    </section>
</main>

<?php HtmlHelper::renderFooter(); ?>