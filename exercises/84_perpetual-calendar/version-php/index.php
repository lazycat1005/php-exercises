<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;
use App\Controller\PerpetualCalendarController;

HtmlHelper::renderHeader('perpetualCalendar', '84perpetualCalendar.css');
?>

<h1>萬年曆-月曆產生器</h1>
<!-- 先生成可供使用者輸入年分與月份的輸入框，方法採用get -->
<form method="get" action="">
    <label for="year">西元年：</label>
    <input type="number" id="year" name="year" min="1" step="1" required>

    <label for="month">月份：</label>
    <input type="number" id="month" name="month" min="1" max="12" step="1" required>

    <button type="submit">生成月曆</button>
</form>
<!-- 接著生成一個7*1的表格，表頭為日、一、二、三、四、五、六 -->
<table>
    <tr>
        <th>日</th>
        <th>一</th>
        <th>二</th>
        <th>三</th>
        <th>四</th>
        <th>五</th>
        <th>六</th>
    </tr>
    <?php
    // 呼叫 Controller 處理 GET 請求與產生日曆
    echo PerpetualCalendarController::handle($_GET['year'] ?? null, $_GET['month'] ?? null);
    ?>
</table>

<?php HtmlHelper::renderFooter(''); ?>