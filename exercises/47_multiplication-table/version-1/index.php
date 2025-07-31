<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;
use App\Controller\MultiplicationTableController;
use App\Views\MultiplicationTableHelper;

// 使用控制器獲取資料
$controller = new MultiplicationTableController();
$tableData = $controller->indexWithDefault();

HtmlHelper::renderHeader('multiplicationTable', '47multiplicationTable.css');
?>

<header>
    <h1>九九乘法表</h1>
    <p>顯示九九乘法表。</p>
</header>

<main>
    <?php echo MultiplicationTableHelper::renderMultiplicationTable($tableData); ?>
</main>

<?php HtmlHelper::renderFooter(); ?>