<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;
use App\Controller\EnglishLettersController;

HtmlHelper::renderHeader('englishLetters', '19englishLetters.css');

$controller = new EnglishLettersController();
?>

<header>
    <h1>判斷字串的ASCII</h1>
    <p>請輸入字串，系統將顯示每個字元的ASCII碼及其類型（大寫、小寫、數字或其他）</p>
</header>

<main class="container">
    <form id="charForm" method="GET">
        <label for="charInput">請輸入字串:</label>
        <input type="text" id="charInput" name="charInput" required>
        <button type="submit">判斷</button>
    </form>

    <section id="result">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['charInput'])) {
            $string = $_GET['charInput'];
            $result = $controller->analyzeString($string);
            if ($result['success']) {
                echo '<ul style="margin-top:1rem;">';
                foreach ($result['data'] as $item) {
                    $char = htmlspecialchars($item['char']);
                    $ascii = $item['ascii'] !== null ? $item['ascii'] : '-';
                    $type = $item['type'];
                    echo "<li>字元: {$char}，ASCII碼: {$ascii}，類型: {$type}</li>";
                }
                echo '</ul>';
            } else {
                echo "<p>{$result['message']}</p>";
            }
        }
        ?>
    </section>
</main>

<?php HtmlHelper::renderFooter(); ?>