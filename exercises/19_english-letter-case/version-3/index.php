<?php
$newCssName = '19englishLetters.css';
$metaKey = "English-letters";
$jsFileName = '19englishLetters.js';
include '../../../header.php';

// 新增：條件式引入控制器
$useController = false;
if (file_exists('../../../app/controller/19EnglishLettersController.php')) {
    require_once '../../../app/controller/19EnglishLettersController.php';
    $controller = new EnglishLettersController();
    $useController = true;
}
?>

<div class="container">
    <h1>判斷英文字母的大小寫</h1>
    <form id="charForm" action="" method="GET">
        <fieldset>
            <label for="charInput">請輸入字元:</label>
            <!-- 使用HTML5的輸入框判斷使用者輸入的字元，並只允許輸入大寫字母 -->
            <input type="text" id="charInput" name="charInput" maxlength="1" pattern="[A-Z]" required
                title="請輸入大寫英文字母 (A-Z)">
            <button type="submit">判斷</button>
        </fieldset>
    </form>

    <div id="result">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['charInput'])) {
            $char = $_GET['charInput'];
            if ($useController) {
                $result = $controller->analyzeCharacter($char, 'upper');
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


<?php include '../../../footer.php'; ?>