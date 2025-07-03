<?php
$metaKey = "textLength";
$exerciseDir = __DIR__ . '/../';
include '../../../header.php';
?>

<body>
    <div class="text-length__container">
        <!-- 標題 -->
        <header class="text-length__header">
            <h1>計算文字</h1>
            <p>版本二: 給予一個 textarea，onblur 後用 JQuery 計算 textarea 已輸入幾個字</p>
        </header>

        <!-- 主結構 -->
        <main>
            <form class="text-length__form">
                <textarea name="text" rows="10" cols="30" placeholder="請在此輸入文字..." onblur="countChars(this)"></textarea>
            </form>

            <div class="text-length__result">
                <p id="charCount">字元個數: 0</p>
            </div>
        </main>
    </div>

    <!-- 返回首頁按鈕 -->
    <a class="fixedBtn" href="../../../index.php">Back</a>

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="./app.js"></script>
</body>

</html>