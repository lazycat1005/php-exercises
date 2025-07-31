<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;
use App\Controller\MultiplicationTableController;
use App\Views\InteractiveMultiplicationTableHelper;

// 使用控制器獲取資料
$controller = new MultiplicationTableController();
$tableData = $controller->index();
$errorMessage = $controller->getErrorMessage();
$userInput = $controller->getUserInput();

HtmlHelper::renderHeader('multiplicationTable', '47multiplicationTable.css');
?>

<header>
    <h1>九九乘法表（互動版）</h1>
    <p>顯示互動式九九乘法表，您可以在答案欄位填入答案進行練習。</p>
</header>

<main>
    <!-- 乘法表的子數量，例如使用者輸入1，則表示只生成1x1的乘法表，輸入2~4則表示生成2x2到4x4的乘法表，輸入1、5則表示生成1x1和5x5的乘法表 -->
    <form method="get">
        <div>
            <label for="subTableInput">請輸入要生成的乘法表子數量（例如：1、2~4、1,5）：</label>
            <input type="text" id="subTableInput" name="subTableInput"
                placeholder="例如：1、2~4、1,5"
                value="<?php echo htmlspecialchars($userInput); ?>">
        </div>
        <?php if (!empty($errorMessage)): ?>
            <div class="errorMessage">
                <?php echo htmlspecialchars($errorMessage); ?>
            </div>
        <?php endif; ?>
        <button type="submit">生成乘法表</button>
    </form>

    <?php if (!empty($tableData)): ?>
        <?php echo InteractiveMultiplicationTableHelper::renderMultiplicationTable($tableData); ?>
    <?php endif; ?>
</main>

<?php HtmlHelper::renderFooter('47multiplicationTable.js'); ?>