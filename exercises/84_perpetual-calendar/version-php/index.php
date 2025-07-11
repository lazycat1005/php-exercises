<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;

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
<table border="1">
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
    function generateCalendar($year, $month)
    {
        // 獲取該月的第一天是星期幾
        $firstDayOfMonth = mktime(0, 0, 0, $month, 1, $year);
        $firstWeekday = date('w', $firstDayOfMonth);

        // 獲取該月的天數
        $daysInMonth = date('t', $firstDayOfMonth);

        // 計算當月的第一個日期
        $currentDay = 1;

        // 開始生成表格行
        echo '<tr>';

        // 填充前面的空白格子
        for ($i = 0; $i < $firstWeekday; $i++) {
            echo '<td></td>';
        }

        // 填充當月的日期
        for ($day = 1; $day <= $daysInMonth; $day++) {
            echo '<td>' . $day . '</td>';

            // 當到達星期六時，換行
            if (($day + $firstWeekday) % 7 == 0) {
                echo '</tr><tr>';
            }
        }

        // 填充後面的空白格子
        while (($daysInMonth + $firstWeekday) % 7 != 0) {
            echo '<td></td>';
            $daysInMonth++;
        }

        echo '</tr>';
    }

    function isValidPositiveInteger($value)
    {
        return is_numeric($value) && ctype_digit($value) && intval($value) > 0;
    }

    if (isset($_GET['year']) && isset($_GET['month'])) {
        $year = intval($_GET['year']);
        $month = intval($_GET['month']);

        if (isset($_GET['year']) && isset($_GET['month'])) {
            $year = $_GET['year'];
            $month = $_GET['month'];

            // 確認輸入的年與月是否有效，只能為正整數，不能為負數、科學記號或小數、字串...
            if (
                isValidPositiveInteger($year) && isValidPositiveInteger($month) &&
                intval($year) > 0 && intval($month) >= 1 && intval($month) <= 12
            ) {
                generateCalendar(intval($year), intval($month));
            } else {
                echo '<tr><td colspan="7">請輸入有效的年與月。</td></tr>';
            }
        }
    }
    ?>
</table>

<?php HtmlHelper::renderFooter('74textLength.js'); ?>