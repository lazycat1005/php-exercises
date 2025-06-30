<?php
$metaKey = "textLength";
$exerciseDir = __DIR__ . '/../';
include '../../../header.php';
?>

<link rel="stylesheet" href="../css/main.css">

<body>
    <div class="text-length__container">
        <!-- 標題 -->
        <header class="text-length__header">
            <h1>計算文字</h1>
            <p>版本三: 限制 textarea 輸入上限為 100 個字，送出後 PHP 驗證超過字數就跳警告</p>
        </header>

        <!-- 主結構 -->
        <main>
            <form class="text-length__form" method="get" action="">
                <textarea name="text" rows="10" cols="30" placeholder="請在此輸入文字..." maxlength="100"></textarea>
                <button type="submit">計算字數</button>
            </form>

            <div class="text-length__result">
                <?php
                // 先驗證使用者無惡意注入攻擊後才計算字元個數
                if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['text'])) {
                    $text = htmlspecialchars($_GET['text'], ENT_QUOTES, 'UTF-8'); // 防止 XSS 攻擊
                    $charCount = mb_strlen($text);

                    if ($charCount > 100) {
                        echo "<p style='color: red;'>字元個數超過限制！請輸入不超過 100 個字。</p>";
                    } else {
                        echo "<p>字元個數: $charCount</p>";
                    }
                }
                ?>
            </div>
        </main>
    </div>

    <!-- 返回首頁按鈕 -->
    <a class="fixedBtn" href="../../../index.php">Back</a>

</body>

</html>