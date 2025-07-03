<?php
$newCssName = '74textLength.css'; // 添加此行
$metaKey = "textLength";
include '../../../header.php';
?>

<body>
    <div class="text-length__container">
        <!-- 標題 -->
        <header class="text-length__header">
            <h1>計算文字</h1>
            <p>版本一: 給予一個 textarea，貼上後送出用 PHP 計算有幾個字</p>
        </header>

        <!-- 主結構 -->
        <main>
            <form class="text-length__form" method="get" action="">
                <textarea name="text" rows="10" cols="30" placeholder="請在此輸入文字..."></textarea>
                <button type="submit">計算字數</button>
            </form>

            <div class="text-length__result">
                <?php
                // 先驗證使用者無惡意注入攻擊後才計算字元個數
                if ($_SERVER["REQUEST_METHOD"] === "GET" && isset($_GET['text'])) {
                    $text = trim($_GET['text']);
                    if ($text === '') {
                        echo '<p style="color:red;">請輸入文字</p>';
                    } elseif (mb_strlen($text) > 1000) {
                        echo '<p style="color:red;">字數不可超過 1000 字</p>';
                    } else {
                        $safeText = htmlspecialchars($text, ENT_QUOTES, 'UTF-8');
                        $charCount = mb_strlen($text);
                        echo "<p>字元個數: $charCount</p>";
                    }
                }
                ?>
            </div>
        </main>
    </div>

    <!-- 返回首頁按鈕 -->
    <a class="fixedBtn" href="../../../index.php">Back</a>

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="./app.js"></script>
</body>

</html>