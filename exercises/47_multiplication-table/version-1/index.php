<?php
$newCssName = '47multiplicationTable.css';
$metaKey = "multiplication-table";
include '../../../header.php';
require_once '../../../app/helper/47MultiplicationTableHelper.php';
?>


<main>
    <h1>九九乘法表</h1>

    <section>
        <h2>九九乘法表（3欄×3列的大表格，每格為5欄×9列的乘法子表格）</h2>
        <table class="outer">
            <?php
            $colsPerRow = 3;
            $rows = 3;
            $tablesPerCell = 5;
            $controllerPath = '../../../app/controller/47MultiplicationTableController.php';

            require_once $controllerPath;
            $controller = new MultiplicationTableController();
            $result = $controller->generateTable('1~9');
            $tableNumbers = $result['numbers'];

            echo MultiplicationTableHelper::renderMultiplicationTable($tableNumbers, $colsPerRow, $rows, $tablesPerCell);
            ?>
        </table>
    </section>
</main>

<?php include '../../../footer.php'; ?>