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
            <p>版本四: 限制 textarea 輸入上限為 100 個字，輸入當下就用 JS 計算 textarea 已輸入幾個字，並且超過字數就不給輸入任何文字</p>
        </header>

        <!-- 主結構 -->
        <main>
            <form class="text-length__form" method="get" action="">
                <textarea name="text" rows="10" cols="30" placeholder="請在此輸入文字..." maxlength="100"></textarea>
            </form>

            <div class="text-length__result">
                <p id="charCount">字元個數: 0</p>
            </div>
        </main>
    </div>

    <!-- 返回首頁按鈕 -->
    <a class="fixedBtn" href="../../../index.php">Back</a>

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $('textarea').on('input', function() {
                const text = $(this).val();
                const charCount = text.length;
                $('#charCount').text('字元個數: ' + charCount);

                // 如果超過 100 個字，就不允許再輸入
                if (charCount >= 100) {
                    $(this).attr('maxlength', '100');
                } else {
                    $(this).removeAttr('maxlength');
                }
            });
        });
    </script>

</body>

</html>