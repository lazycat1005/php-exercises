<?php session_start(); ?>

<?php
require_once '../../../app/helper/HtmlHelper.php';
HtmlHelper::renderHeader('guessNumber', '04lotteryApp.css');
?>


<header>
    <h1>樂透APP</h1>
</header>

<main>
    <?php
    // 初始化訊息與開獎結果變數
    $successMsg = '';
    $errorMsg = '';
    $alertMsg = '';
    $drawResult = null;

    // 初始化 session 紀錄
    if (!isset($_SESSION['lottery_records'])) {
        $_SESSION['lottery_records'] = [];
    }

    if (!isset($_SESSION['drawn'])) {
        $_SESSION['drawn'] = false;
    }

    // 表單送出處理
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (isset($_POST['clear']) && $_POST['clear'] === '1') {
            // 清除所有紀錄與開獎狀態
            $_SESSION['lottery_records'] = [];
            $_SESSION['drawn'] = false;
            unset($_SESSION['draw_result']);
            $successMsg = '所有已儲存的號碼已清除！';
            $numbers = [];
        } elseif (isset($_POST['draw'])) {
            // 開獎流程
            if (!empty($_SESSION['lottery_records']) && !$_SESSION['drawn']) {
                $pool = range(1, 42);
                shuffle($pool);
                $mainNumbers = array_slice($pool, 0, 6);
                sort($mainNumbers, SORT_NUMERIC);
                // 取出剩下的號碼作為特別號
                $remaining = array_diff($pool, $mainNumbers);
                $specialNumber = array_shift($remaining);
                $_SESSION['draw_result'] = [
                    'main' => $mainNumbers,
                    'special' => $specialNumber
                ];
                $_SESSION['drawn'] = true;
                $drawResult = $_SESSION['draw_result'];
            }
        } else {
            // 處理下注選號
            $numbers = isset($_POST['numbers']) ? $_POST['numbers'] : [];
            // 驗證：必須剛好6個且無重複
            if (count($numbers) !== 6) {
                $alertMsg = '請選擇 6 個號碼！';
            } elseif (count($numbers) !== count(array_unique($numbers))) {
                $alertMsg = '選號有重複，請重新選擇！';
            } else {
                sort($numbers, SORT_NUMERIC);
                $_SESSION['lottery_records'][] = [
                    'time' => date('Y-m-d H:i:s'),
                    'numbers' => $numbers
                ];
                $successMsg = '已成功送出！您的選號為：' . implode(', ', $numbers);
                // 送出成功後清空選取
                $numbers = [];
            }
        }
    }

    // 若已開獎，取出結果
    if (isset($_SESSION['draw_result'])) {
        $drawResult = $_SESSION['draw_result'];
    }
    ?>
    <?php if ($successMsg): ?>
        <div class="msg-success"><?php echo htmlspecialchars($successMsg); ?></div>
    <?php endif; ?>

    <?php if ($errorMsg): ?>
        <div class="msg-error"><?php echo htmlspecialchars($errorMsg); ?></div>
    <?php endif; ?>

    <?php if ($alertMsg): ?>
        <div class="msg-alert"><?php echo htmlspecialchars($alertMsg); ?></div>
    <?php endif; ?>

    <!-- 樂透選號表單 -->
    <form method="post" id="lotteryForm"
        <?php if ($_SESSION['drawn']) echo 'style="pointer-events:none;opacity:0.6;"'; ?>>
        <fieldset>
            <legend>請選擇 6 個號碼：</legend>
            <div class="lotto-numbers">
                <?php for ($i = 1; $i <= 42; $i++): ?>
                    <label class="lotto-label">
                        <input type="checkbox" name="numbers[]" value="<?php echo $i; ?>"
                            <?php
                            if (!empty($numbers) && in_array($i, $numbers)) echo 'checked';
                            if ($_SESSION['drawn']) echo ' disabled';
                            ?>> <?php echo $i; ?>
                    </label>
                <?php endfor; ?>
            </div>
        </fieldset>
        <button type="submit" class="btn-submit" <?php if ($_SESSION['drawn']) echo 'disabled'; ?>>下注</button>
        <button type="button" id="resetNumbers" class="btn-reset" <?php if ($_SESSION['drawn']) echo 'disabled'; ?>>重選</button>
        <button type="button" id="autoPick" class="btn-auto" <?php if ($_SESSION['drawn']) echo 'disabled'; ?>>電腦選號</button>
    </form>

    <!-- 清除所有紀錄按鈕 -->
    <form method="post" class="inline-form">
        <input type="hidden" name="clear" value="1">
        <button type="submit" class="btn-clear">清除所有紀錄</button>
    </form>

    <!-- 開獎按鈕 -->
    <form method="post" class="inline-form">
        <input type="hidden" name="draw" value="1">
        <button type="submit" id="drawBtn"
            <?php
            if ($_SESSION['drawn'] || empty($_SESSION['lottery_records'])) echo 'disabled class="btn-draw-disabled"';
            else echo 'class="btn-draw"';
            ?>>開獎</button>
    </form>

    <?php if (!empty($_SESSION['lottery_records'])): ?>
        <section class="records-section">
            <h2>已下注的號碼紀錄</h2>
            <ol>
                <?php
                // 若已開獎，準備比對中獎號碼
                $highlightNumbers = [];
                if ($drawResult) {
                    $highlightNumbers = array_merge($drawResult['main'], [$drawResult['special']]);
                }
                foreach ($_SESSION['lottery_records'] as $record): ?>
                    <li>
                        <!-- 顯示下注時間 -->
                        <span class="record-time"><?php echo htmlspecialchars($record['time']); ?></span>
                        ：
                        <strong>
                            <?php
                            // 顯示下注號碼
                            $nums = [];
                            foreach ($record['numbers'] as $num) {
                                $nums[] = htmlspecialchars($num);
                            }
                            echo implode(', ', $nums);
                            ?>
                        </strong>
                    </li>
                <?php endforeach; ?>
            </ol>
        </section>
    <?php endif; ?>

    <?php if ($drawResult): ?>
        <section class="draw-section">
            <h2 class="draw-title">開獎結果</h2>
            <div id="drawResultArea">
                號碼：
                <strong class="draw-main">
                    <?php foreach ($drawResult['main'] as $idx => $num): ?>
                        <!-- 主要中獎號碼 -->
                        <span class="lotto-main" style="display:none;"><?php echo $num; ?></span><?php if ($idx < count($drawResult['main']) - 1) echo ', '; ?>
                    <?php endforeach; ?>
                </strong>
                <br>
                特別號：
                <strong class="draw-special">
                    <!-- 特別號 -->
                    <span class="lotto-special" style="display:none;"><?php echo $drawResult['special']; ?></span>
                </strong>
            </div>
        </section>
    <?php endif; ?>
</main>

<?php
$jsFileName = '04lotteryApp.js';
include '../../../footer.php';
?>