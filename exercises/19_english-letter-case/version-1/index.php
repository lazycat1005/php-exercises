<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;
use App\Controller\EnglishLettersController;

HtmlHelper::renderHeader('englishLetters', '19englishLetters.css');

$controller = new EnglishLettersController();
?>


<div class="container">
    <h1>判斷字串的ASCII</h1>
    <form id="charForm" action="" method="GET">
        <fieldset>
            <label for="charInput">請輸入字串:</label>
            <input type="text" id="charInput" name="charInput" required>
            <button type="submit">判斷</button>
        </fieldset>
    </form>

    <div id="result">
        <?php
        if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['charInput'])) {
            $string = $_GET['charInput'];
            $result = $controller->analyzeString($string);
            if ($result['success']) {
                echo '<ul style="margin-top:1.2rem;">';
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
    </div>
</div>


<?php HtmlHelper::renderFooter(); ?>