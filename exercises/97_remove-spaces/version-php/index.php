<?php
$newCssName = '97removeSpaces.css'; // 添加此行
$metaKey = "removeSpaces";
include '../../../header.php';
?>


<div class="remove-spaces">
    <header class="remove-spaces__header">
        <h1>PHP 練習題：移除字串中的空格</h1>
        <p>給予一個輸入框，送出後 PHP 會清除字串裡所有的空格，然後過濾後的字串重新顯示再輸入框內</p>
    </header>

    <?php
    $inputString = '';
    $filteredString = '';
    $controllerPath = '../../../app/controller/97RemoveSpacesController.php';

    require_once $controllerPath;
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

    <main class="remove-spaces__main">
        <form action="" method="get">
            <label for="inputString">請輸入字串：</label>
            <input type="text" id="inputString" name="inputString" value="<?php echo htmlspecialchars($filteredString); ?>" required>
            <button type="submit">送出</button>
        </form>
    </main>
</div>

<?php include '../../../footer.php'; ?>