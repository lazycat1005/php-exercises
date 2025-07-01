<?php
$metaKey = "mergeFiles";
$exerciseDir = __DIR__ . '/../';
include '../../../header.php';
?>

<body>
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
            //驗證使用者的檔案是否為純txt檔案，若是由其他檔案改副檔名而來的txt檔案，則不予合併，合併成新txt檔案後提供下載鏈結給使用者
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                if (isset($_FILES['file1']) && isset($_FILES['file2'])) {
                    $file1 = $_FILES['file1'];
                    $file2 = $_FILES['file2'];

                    // 檢查檔案是否為txt格式
                    if ($file1['type'] === 'text/plain' && $file2['type'] === 'text/plain') {
                        // 讀取檔案內容
                        $content1 = file_get_contents($file1['tmp_name']);
                        $content2 = file_get_contents($file2['tmp_name']);

                        // 合併內容
                        $mergedContent = $content1 . "\n" . $content2;

                        // 儲存合併後的檔案
                        $mergedFileName = 'merged_file.txt';
                        file_put_contents($mergedFileName, $mergedContent);

                        // 提供下載鏈結
                        echo "<div class='file-merger__result file-merger__result--success'>";
                        echo "<p>檔案合併成功！<a href='$mergedFileName' download>點此下載合併後的檔案</a></p>";
                        echo "</div>";
                    } else {
                        echo "<div class='file-merger__result file-merger__result--error'>";
                        echo "<p>請上傳純文字檔案（.txt）！</p>";
                        echo "</div>";
                    }
                } else {
                    echo "<div class='file-merger__result file-merger__result--error'>";
                    echo "<p>請選擇兩個檔案進行合併。</p>";
                    echo "</div>";
                }
            }
            ?>
        </main>
    </div>

    <!-- 返回首頁按鈕 -->
    <a class="fixedBtn" href="../../../index.php">Back</a>
</body>

</html>