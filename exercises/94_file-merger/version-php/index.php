<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;
use App\Controller\FileMergerController;

HtmlHelper::renderHeader('mergeFiles', '94fileMerger.css');
?>


<div class="file-merger__container">
    <!-- 標題 -->
    <header class="file-merger__header">
        <h1>合併兩個檔案</h1>
        <p>建立一個表單容器，裡面有兩個輸入框可供使用者上傳檔案1與檔案2，還有一個按鈕提交</p>
    </header>

    <!-- 主結構 -->
    <main>
        <form id="mergeForm" class="file-merger__form" action="" method="post" enctype="multipart/form-data">
            <div class="file-merger__field">
                <label for="file1">檔案1：</label>
                <input type="file" id="file1" name="file1" accept=".txt" required>
            </div>
            <div class="file-merger__field">
                <label for="file2">檔案2：</label>
                <input type="file" id="file2" name="file2" accept=".txt" required>
            </div>
            <button type="submit" class="file-merger__submit-btn">合併檔案</button>
        </form>

        <?php
        // 處理表單提交
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_FILES['file1']) && isset($_FILES['file2'])) {
                $controller = new FileMergerController();
                $result = $controller->mergeFiles($_FILES['file1'], $_FILES['file2']);
                echo $result['html'];
            } else {
                echo "<div class='file-merger__result file-merger__result--error'><p>請選擇兩個檔案進行合併。</p></div>";
            }
        }
        ?>
    </main>
</div>

<?php HtmlHelper::renderFooter(); ?>