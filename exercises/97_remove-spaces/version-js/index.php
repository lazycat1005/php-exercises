<?php
$metaKey = "removeSpaces";
$exerciseDir = __DIR__ . '/../';
include '../../../header.php';
?>

<body>
    <div class="remove-spaces">
        <header class="remove-spaces__header">
            <h1>移除字串中的空格</h1>
            <p>給予一個輸入框，onblur 後用 JQuery 清除字串裡所有的空格，然後取代原本輸入框內的值，並提示"字串已更動"</p>
        </header>
        <main class="remove-spaces__main">
            <form id="inputForm">
                <label for="inputString">請輸入字串：</label>
                <input type="text" id="inputString" name="inputString" required>
            </form>
            <p id="message"></p>
        </main>
        <a class="fixedBtn" href="../../../index.php">Back</a>
    </div>

    <!-- 引入jQuery1.12.4 -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script>
        // 當輸入框失去焦點時，清除字串中的空格並更新輸入框的值
        // 使用正則表達式 /\s+/g 來匹配所有空格
        $(document).ready(function() {
            $('#inputForm').on('submit', function(e) {
                e.preventDefault();
            });
            $('#inputString').on('blur', function() {
                const inputString = $(this).val();
                const filteredString = inputString.replace(/\s+/g, '');
                $(this).val(filteredString);
                $('#message').text('字串已更動');
            });
        });
    </script>
</body>

</html>