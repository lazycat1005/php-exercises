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
                <!-- 使用HTML5的輸入框判斷使用者輸入的字元，並只允許輸入英文字母 -->
                <input type="text" id="charInput" name="charInput" maxlength="1" pattern="[A-Za-z]" required autocomplete="off" />

                <button type="submit">判斷</button>
            </fieldset>
        </form>

        <div id="result">
            <?php
            if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['charInput'])) {
                $char = $_GET['charInput'];
                // 驗證，如果不是英文字母，返回警告
                if (!preg_match('/^[A-Za-z]$/', $char)) {
                    echo "<p>請輸入英文字母 (A-Z, a-z)。</p>";
                }
                if (strlen($char) !== 1) {
                    echo "<p>請輸入單一字元。</p>";
                } else {
                    //不管使用者輸入大寫或小寫字母，一率轉換成大寫字母並輸出到畫面上
                    $upperChar = strtoupper($char);
                    echo "<p>轉換成大寫字母：<strong>{$upperChar}</strong></p>";
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