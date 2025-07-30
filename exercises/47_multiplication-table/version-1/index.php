<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;
use App\Controller\MultiplicationTableController;
use App\Views\MultiplicationTableHelper;

HtmlHelper::renderHeader('multiplicationTable', '47multiplicationTable.css');
?>

<header>
    <h1>九九乘法表</h1>
    <p>顯示九九乘法表。</p>
</header>

<main>
    <h2>九九乘法表（3欄×3列的大表格，每格為5欄×9列的乘法子表格）</h2>
    <table class="outer">
        <?php
        $colsPerRow = 3;
        $rows = 3;
        $tablesPerCell = 5;
        $controller = new MultiplicationTableController();
        $result = $controller->generateTable('1~9');
        $tableNumbers = $result['numbers'];

        echo MultiplicationTableHelper::renderMultiplicationTable($tableNumbers, $colsPerRow, $rows, $tablesPerCell);
        ?>
    </table>
</main>

<?php HtmlHelper::renderFooter(); ?>