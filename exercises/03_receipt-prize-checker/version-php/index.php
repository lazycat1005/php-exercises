<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['clear_logs'])) {
    $_SESSION['logs'] = [];
    // 重導回自己，讓後續 GET 正常走完整個頁面輸出
    header('Location: ' . $_SERVER['PHP_SELF']);
    exit;
}

HtmlHelper::renderHeader('receiptPrizeChecker', '03receiptPrizeChecker.css');
?>

<main>
    <header>
        <h1>發票對獎APP</h1>
        <p>114年3~4月發票對獎器</p>
    </header>

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

    <section>
        <h3>請輸入您的發票號碼(可任意輸入末幾碼做查詢)</h3>
        <form method="post" action="">
            <label for="receipt">發票號碼：</label>
            <input type="number" id="receipt" name="receipt" min="1" max="99999999" step="1" required>
            <button type="submit">檢查</button>
        </form>

        <?php

        $specialPrize1 = '64557267';
        $specialPrize2 = '64808075';
        $firstPrizes = ['04322277', '07903676', '98883497'];

        //驗證的function
        function checkReceipt($receipt, $specialPrize1, $specialPrize2, $firstPrizes)
        {
            // 只接受數字字串，3~8碼
            if (!preg_match('/^[0-9]{3,8}$/', $receipt)) {
                return '請輸入 3~8 位數的有效發票號碼。';
            }

            // 若剛好是 8 碼，可比對特等獎與特獎
            if (strlen($receipt) === 8) {
                if ($receipt === $specialPrize1) {
                    return '特等獎1000萬';
                }
                if ($receipt === $specialPrize2) {
                    return '特獎200萬';
                }
            }

            // 比對頭獎
            $awardLevels = [
                8 => '頭獎20萬',
                7 => '末7碼中4萬',
                6 => '末6碼中1萬',
                5 => '末5碼中4000',
                4 => '末4碼中1000',
                3 => '末3碼中200',
            ];

            foreach ($firstPrizes as $prize) {
                // 從 8 碼一路比到 3 碼
                for ($len = 8; $len >= 3; $len--) {
                    if (strlen($receipt) >= $len) {
                        $userTail = substr($receipt, -$len);
                        $prizeTail = substr($prize, -$len);
                        if ($userTail === $prizeTail) {
                            return "{$awardLevels[$len]}";
                        }
                    }
                }
            }
            return '沒中獎。';
        }

        ?>

        <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $input = trim($_POST['receipt'] ?? '');
            if ($input !== '') {
                $result = checkReceipt($input, $specialPrize1, $specialPrize2, $firstPrizes);
                // 儲存紀錄到 session
                $_SESSION['logs'][] = [
                    'number' => $input,
                    'result' => $result,
                ];
            }
        }
        ?>

    </section>

    <section>
        <h2>對獎紀錄</h2>
        <form method="post">
            <button type="submit" name="clear_logs" value="1">清空紀錄</button>
        </form>

        <?php foreach (array_reverse($_SESSION['logs']) as $log): ?>
            <div class="log">
                <h4>號碼：<?= htmlspecialchars($log['number']) ?></h4>
                <p><?= htmlspecialchars($log['result']) ?></p>
            </div>
        <?php endforeach; ?>
    </section>

</main>


<?php HtmlHelper::renderFooter(); ?>