<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;
use App\Controller\MultiplicationTableController;
use App\Helper\MultiplicationTableHelper;

HtmlHelper::renderHeader('multiplicationTable', '47multiplicationTable.css');
?>



<main>
    <h1>九九乘法表</h1>

    <section>
        <form method="get" action="" id="tableForm">
            <label for="tableCount">請輸入要產生哪些乘法表（例如：1~8、2、4,6,9、1~2,6,9）：</label>
            <input type="text" id="tableCount" name="tableCount" autocomplete="off"
                pattern="^[0-9,，~\- ]+$"
                value="<?php echo isset($_GET['tableCount']) ? htmlspecialchars($_GET['tableCount']) : '9'; ?>">
            <button type="submit">產生</button>
            <span id="inputError" style="color:red;margin-left:1em;"></span>
        </form>
    </section>

    <section>
        <h2>九九乘法表互動小遊戲（依序作答，答對才可輸入下一題）</h2>
        <table class="outer">
            <?php
            $colsPerRow = 3;
            $rows = 3;
            $tablesPerCell = 5;
            $input = isset($_GET['tableCount']) ? $_GET['tableCount'] : '9';
            $showError = false;
            $controller = new MultiplicationTableController();
            $result = $controller->generateTable($input);
            $showError = !$result['success'];
            $tableNumbers = $result['numbers'];

            if (empty($tableNumbers) && !$showError) {
                $tableNumbers = [9];
            }
            echo MultiplicationTableHelper::renderMultiplicationTable($tableNumbers, $colsPerRow, $rows, $tablesPerCell, true);
            ?>
        </table>
        <?php if ($showError): ?>
            <div style="color:red;">請勿輸入文字、科學符號、運算符號、小數點或超過9的數字</div>
        <?php endif; ?>
    </section>
</main>

<?php HtmlHelper::renderFooter('47multiplicationTable.js'); ?>