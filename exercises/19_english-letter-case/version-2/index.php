<?php
$metaKey = "English-letters";
$exerciseDir = __DIR__ . '/../';
include '../../../header.php';
?>

<body>
    <div class="container">
        <h1>判斷英文字母的大小寫</h1>
        <form id="charForm" action="" method="GET">
            <fieldset>
                <label for="charInput">請輸入字元:</label>
                <input type="text" id="charInput" name="charInput" maxlength="1" required>
                <button type="submit">判斷</button>
            </fieldset>
        </form>

        <div id="result">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['charInput'])) {
                $char = $_GET['charInput'];
                // 驗證，如果不是大寫字母，返回警告
                if (!preg_match('/^[A-Z]$/', $char)) {
                    echo "<p>請輸入大寫英文字母 (A-Z)。</p>";
                }

                if (strlen($char) !== 1) {
                    echo "<p>請輸入單一字元。</p>";
                } else {
                    $singleChar = mb_substr($char, 0, 1, "UTF-8");
                    $ascii = ord($singleChar);
                    if ($ascii >= 65 && $ascii <= 90) {
                        echo "<p>字元: " . htmlspecialchars($singleChar) . "，ASCII碼: $ascii" . "類型: 大寫英文字母</p>";
                    }
                }
            }
            ?>
        </div>
    </div>

    <a class="fixedBtn" href="../../../index.php">Back</a>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"
        integrity="sha512-jGsMH83oKe9asCpkOVkBnUrDDTp8wl+adkB2D+//JtlxO4SrLoJdhbOysIFQJloQFD+C4Fl1rMsQZF76JjV0eQ=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script src="./app.js"></script>
</body>

</html>