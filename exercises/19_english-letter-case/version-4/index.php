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
            <label for="charInput">請輸入英文字串:</label>
            <!-- 使用HTML5的輸入框判斷使用者輸入的字串，並只允許輸入英文字母 -->
            <input type="text" id="charInput" name="charInput" pattern="[A-Za-z]+" required autocomplete="off" />

            <button type="submit">判斷</button>
        </fieldset>
    </form>

    <div id="result">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['charInput'])) {
            $input = $_GET['charInput'];
            $result = $controller->analyzeAndConvertToUpper($input);
            if ($result['success']) {
                $data = $result['data'];
                echo "<p>原始輸入: " . htmlspecialchars($data['original']) . "</p>";
                echo "<p>轉換結果: " . htmlspecialchars($data['converted']) . " (長度: {$data['length']})</p>";
                echo "<h3>字元分析:</h3>";
                echo "<ul>";
                foreach ($data['characters'] as $index => $charData) {
                    echo "<li>第" . ($index + 1) . "個字元: " . htmlspecialchars($charData['char']) . " (ASCII: {$charData['ascii']})</li>";
                }
                echo "</ul>";
            } else {
                echo "<p>{$result['message']}</p>";
            }
        }
        ?>
    </div>
</div>

<?php HtmlHelper::renderFooter('19englishLetters.js'); ?>