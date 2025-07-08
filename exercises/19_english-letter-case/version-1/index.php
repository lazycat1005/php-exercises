<?php
require_once '../../../app/helper/HtmlHelper.php';
HtmlHelper::renderHeader('English-letters', '19englishLetters.css');

// 新增：條件式引入控制器
$useController = false;
if (file_exists('../../../app/controller/19EnglishLettersController.php')) {
    require_once '../../../app/controller/19EnglishLettersController.php';
    $controller = new EnglishLettersController();
    $useController = true;
}
?>


<!-- 提供一個輸入框可輸入一串字，利用 PHP 把它們都切割出來成一個字元，並顯示它對應的 ASCII code ，且標註是英文大寫 or 英文小寫 or 半形符號 or 其他字元(分辨不出是前三類的就是其他字元) -->
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
            if ($useController) {
                $result = $controller->analyzeCharacter($char, 'both');
                if ($result['success']) {
                    $data = $result['data'];
                    echo "<p>字元: " . htmlspecialchars($data['char']) . "，ASCII碼: {$data['ascii']}，類型: {$data['type']}</p>";
                } else {
                    echo "<p>{$result['message']}</p>";
                }
            }
        }
        ?>
    </div>
</div>


<?php HtmlHelper::renderFooter(); ?>