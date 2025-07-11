<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;
use App\Validator\ReceiptPrizeCheckerValidator;
use App\Controller\ReceiptPrizeCheckerController;

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

        $error = '';

        $result = '';

        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['receipt'])) {
            $input = trim($_POST['receipt']);
            $validate = ReceiptPrizeCheckerValidator::validateReceipt($input);
            if ($validate !== true) {
                $error = $validate;
            } else {
                $controller = new ReceiptPrizeCheckerController($specialPrize1, $specialPrize2, $firstPrizes);
                $result = $controller->checkReceipt($input);
                // 儲存紀錄到 session
                $_SESSION['logs'][] = [
                    'number' => $input,
                    'result' => $result,
                ];
            }
        }
        ?>
        <?php if (!empty($error)): ?>
            <div class="error" style="color:red;"> <?= htmlspecialchars($error) ?> </div>
        <?php elseif (!empty($result)): ?>
            <div class="result"> <?= htmlspecialchars($result) ?> </div>
        <?php endif; ?>
    </section>

    <section>
        <h2>對獎紀錄</h2>
        <form method="post">
            <button type="submit" name="clear_logs" value="1">清空紀錄</button>
        </form>

        <?php if (!empty($_SESSION['logs'])): ?>
            <?php foreach (array_reverse($_SESSION['logs']) as $log): ?>
                <div class="log">
                    <h4>號碼：<?= htmlspecialchars($log['number']) ?></h4>
                    <p><?= htmlspecialchars($log['result']) ?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </section>

</main>


<?php HtmlHelper::renderFooter(); ?>