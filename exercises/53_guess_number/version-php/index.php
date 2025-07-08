<?php session_start(); ?>

<?php
$newCssName = '53guessNumber.css';
$metaKey = "guessNumber";
include '../../../header.php';
?>

<?php
$message = '';
$disabledStart = '';
$disabledGuess = 'disabled';
$disabledReveal = 'disabled';

// 按下 [開始] 按鈕
if (isset($_POST['start'])) {
    $_SESSION['answer'] = rand(1, 100);
    $_SESSION['guessed'] = false;
    $_SESSION['revealed'] = false;
    $message = "已產生 1~100 的隨機數，請開始猜！";
}

// 按下 [送出] 猜數字
if (isset($_POST['submit']) && isset($_SESSION['answer']) && !$_SESSION['guessed'] && !$_SESSION['revealed']) {
    $guess = intval($_POST['guess']);
    $answer = $_SESSION['answer'];

    if ($guess == $answer) {
        $message = "猜對了！答案是 " . htmlspecialchars($answer) . "。";
        $_SESSION['guessed'] = true;
    } elseif ($guess > $answer) {
        $message = "太大了";
    } else {
        $message = "太小了";
    }
}

// 按下 [公布答案]
if (isset($_POST['reveal']) && isset($_SESSION['answer'])) {
    $message = "答案是：" . $_SESSION['answer'];
    $_SESSION['revealed'] = true;
}

// 控制按鈕狀態
if (!isset($_SESSION['answer']) || $_SESSION['guessed'] || $_SESSION['revealed']) {
    $disabledStart = '';
    $disabledGuess = 'disabled';
    $disabledReveal = 'disabled';
} else {
    $disabledStart = 'disabled';
    $disabledGuess = '';
    $disabledReveal = '';
}
?>

<h1>猜數字遊戲 (1~100)</h1>

<form method="post">
    <button type="submit" name="start" <?= $disabledStart ?>>開始</button>
    <button type="submit" name="reveal" <?= $disabledReveal ?>>公布答案</button>
</form>

<div class="input-box">
    <form method="post">
        <label for="guess">你的猜測：</label>
        <input type="number" id="guess" name="guess" min="1" max="100" required <?= $disabledGuess ?>>
        <button type="submit" name="submit" <?= $disabledGuess ?>>送出</button>
    </form>
</div>

<?php if ($message): ?>
    <div id="message">
        <strong><?= htmlspecialchars($message) ?></strong>
    </div>
<?php endif; ?>

<?php include '../../../footer.php'; ?>