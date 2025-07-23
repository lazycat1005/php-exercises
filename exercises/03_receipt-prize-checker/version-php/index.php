<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;
use App\Controller\ReceiptPrizeCheckerController;

// 將每次使用者的每筆結果記入session中並顯示出來
session_start();
if (!isset($_SESSION['results'])) {
    $_SESSION['results'] = [];
}

// 處理 GET 表單提交並執行 PRG
ReceiptPrizeCheckerController::handleFormSubmission();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_history'])) {
    $_SESSION['results'] = [];
    // 重新導向，移除所有 GET 參數
    header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
    exit;
}

HtmlHelper::renderHeader('receiptPrizeChecker', '03receiptPrizeChecker.css');
?>

<header>
    <h1>發票對獎系統</h1>
    <p>114年3~4月發票對獎器</p>
</header>

<main>
    <section>
        <div>
            <h2>本期特獎號碼為(1000萬)</h2>
            <ul>
                <li>64557267</li>
            </ul>
        </div>

        <div>
            <h2>本期特獎號碼為(200萬)</h2>
            <ul>
                <li>64808075</li>
            </ul>
        </div>

        <div>
            <h2>本期頭獎號碼為</h2>
            <ul>
                <li>04322277</li>
                <li>07903676</li>
                <li>98883497</li>
            </ul>
        </div>
    </section>

    <form method="get">
        <label for="receipt">請輸入發票號碼：</label>
        <input type="number" id="receipt" name="receipt" required>
        <button type="submit">查詢</button>
    </form>

    <form method="post">
        <button type="submit" name="clear_history" value="1">清除紀錄</button>
    </form>

    <div class="messageText">
        <?php

        // 顯示這次查詢結果
        function displayCurrentResult($result)
        {
            if (!empty($result)) {
                echo "<div class='current-result'>";
                echo "發票號碼：<strong>" . htmlspecialchars($result['number']) . "</strong><br>";
                echo "獎項：<strong>" . htmlspecialchars($result['label']) . "</strong><br>";
                if ($result['amount'] > 0) {
                    echo "獎金：<strong>" . number_format($result['amount']) . "元</strong><br>";
                }
                echo "<span>" . htmlspecialchars($result['msg']) . "</span>";
                echo "</div>";
            }
        }

        // 顯示歷史查詢紀錄 function
        function displayHistory()
        {
            if (!empty($_SESSION['results'])) {
                echo "<hr><h3>本期發票紀錄</h3><ol>";
                foreach (array_reverse($_SESSION['results']) as $item) {
                    echo "<li>";
                    echo "號碼：" . htmlspecialchars($item['number']) . "，";
                    echo "獎項：" . htmlspecialchars($item['label']);
                    if ($item['amount'] > 0) {
                        echo "，獎金：" . number_format($item['amount']) . "元";
                    }
                    echo "</li>";
                }
                echo "</ol>";
            }
        }

        // 取得本次查詢結果（PRG 後從 session 中獲取）
        $result = !empty($_SESSION['results']) ? end($_SESSION['results']) : null;

        // 顯示查詢結果
        displayCurrentResult($result);

        // 呼叫顯示歷史紀錄
        displayHistory();

        ?>
    </div>
</main>

<?php HtmlHelper::renderFooter(); ?>