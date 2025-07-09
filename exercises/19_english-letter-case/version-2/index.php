<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;
use App\Controller\EnglishLettersController;

HtmlHelper::renderHeader('englishLetters', '19englishLetters.css');

$controller = new EnglishLettersController();
?>

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
            $result = $controller->analyzeCharacter($char, 'upper');
            if ($result['success']) {
                $data = $result['data'];
                echo "<p>字元: " . htmlspecialchars($data['char']) . "，ASCII碼: {$data['ascii']}，類型: {$data['type']}</p>";
            } else {
                echo "<p>{$result['message']}</p>";
            }
        }
        ?>
    </div>
</div>

<?php HtmlHelper::renderFooter('19englishLetters.js'); ?>