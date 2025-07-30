<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;

session_start();
HtmlHelper::renderHeader('guessNumber', '53guessNumber.css');
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

<header>
    <h1>猜數字遊戲 (1~100)</h1>
    <p>點擊 [開始] 產生隨機數字，然後猜測這個數字。你可以在猜測後點擊 [公布答案] 來查看正確答案。</p>
</header>

<main class="container">
    <form method="post" id="gameBtnForm">
        <button type="submit" name="start" <?= $disabledStart ?>>開始遊戲</button>
        <button type="submit" name="reveal" <?= $disabledReveal ?>>公布答案</button>
    </form>

    <form method="post" class="input-box">
        <div>
            <label for="guess">你的猜測：</label>
            <input type="number" id="guess" name="guess" min="1" max="100" required <?= $disabledGuess ?>>
        </div>
        <button type="submit" name="submit" <?= $disabledGuess ?>>送出</button>
    </form>

    <?php if ($message): ?>
        <section id="message">
            <strong><?= htmlspecialchars($message) ?></strong>
        </section>
    <?php endif; ?>
</main>

<?php HtmlHelper::renderFooter(); ?>