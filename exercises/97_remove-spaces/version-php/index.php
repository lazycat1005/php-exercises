<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;
use App\Controller\RemoveSpacesController;

HtmlHelper::renderHeader('removeSpaces', '97removeSpaces.css');
?>

<header>
    <h1>PHP 練習題：移除字串中的空格</h1>
    <p>給予一個輸入框，送出後 PHP 會清除字串裡所有的空格，然後過濾後的字串重新顯示再輸入框內</p>
</header>

<main class="container">
    <?php
    $inputString = '';
    $filteredString = '';
    // 檢查是否有提交的字串
    if (isset($_GET['inputString'])) {
        $inputString = $_GET['inputString'];
        $controller = new RemoveSpacesController();
        $result = $controller->removeSpaces($inputString);
        $filteredString = $result['filtered'];
        if (!$result['success']) {
            echo $result['html'];
        }
    }
    ?>

    <form action="" method="get">
        <label for="inputString">請輸入字串：</label>
        <input type="text" id="inputString" name="inputString" value="<?php echo htmlspecialchars($filteredString); ?>" required>
        <button type="submit">送出</button>
    </form>
</main>


<?php HtmlHelper::renderFooter(); ?>