<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;
use App\Controller\EnglishLettersController;

HtmlHelper::renderHeader('englishLetters', '19englishLetters.css');

$controller = new EnglishLettersController();
?>

<header>
    <h1>判斷英文字母的大小寫</h1>
    <p>請輸入字串，系統將顯示每個字元的ASCII碼及其類型（大寫、小寫、數字或其他）</p>
</header>

<main class="container">
    <form id="charForm" action="" method="GET">
        <label for="charInput">請輸入英文字串:</label>
        <input type="text" id="charInput" name="charInput" pattern="[A-Za-z]+" required autocomplete="off" />
        <button type="submit">判斷</button>
    </form>

    <section id="result">
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
    </section>
</main>

<?php HtmlHelper::renderFooter('19englishLetters.js'); ?>