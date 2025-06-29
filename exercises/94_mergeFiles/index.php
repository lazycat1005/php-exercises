<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="index,follow">
    <meta name="googlebot" content="index,follow">
    <meta name="format-detection" content="telephone=no">
    <link rel="icon" sizes="192x192" href="#">
    <title>網頁標題</title>
    <meta name="description" content="網頁簡介">
    <link rel="stylesheet" href="./css/main.css">
</head>

<body>
    <!-- 建立一個表單容器，裡面有兩個輸入框可供使用者上傳檔案1與檔案2，還有一個按鈕提交 -->
    <main>
        <h1>合併兩個檔案</h1>
        <form id="mergeForm" action="" method="post" enctype="multipart/form-data">
            <label for="file1">檔案1：</label>
            <input type="file" id="file1" name="file1" accept=".txt" required>
            <br>
            <label for="file2">檔案2：</label>
            <input type="file" id="file2" name="file2" accept=".txt" required>
            <br>
            <button type="submit">合併檔案</button>
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
                    echo "<p>檔案合併成功！<a href='$mergedFileName' download>點此下載合併後的檔案</a></p>";
                } else {
                    echo "<p style='color: red;'>請上傳純文字檔案（.txt）！</p>";
                }
            } else {
                echo "<p style='color: red;'>請選擇兩個檔案進行合併。</p>";
            }
        }
        ?>
</body>

</html>