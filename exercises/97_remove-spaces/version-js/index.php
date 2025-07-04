<?php
$newCssName = '97removeSpaces.css';
$metaKey = "removeSpaces";
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
    <script src="/PHP-Exercises/assets/js/97removeSpaces.js"></script>
</body>

</html>