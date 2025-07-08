<?php
// 設定Web根目錄路徑
$webRoot = '/PHP-Exercises/';

// 處理專屬JavaScript檔案引入
$jsScriptTag = '';
if (isset($jsFileName) && !empty($jsFileName)) {
    $jsRealPath = __DIR__ . '/assets/js/' . $jsFileName;
    $jsUrlPath = $webRoot . 'assets/js/' . $jsFileName;

    if (file_exists($jsRealPath)) {
        $jsVer = filemtime($jsRealPath);
        $jsUrlPath .= '?v=' . $jsVer;
        $jsScriptTag = '<script src="' . htmlspecialchars($jsUrlPath) . '"></script>';
    }
}
?>

<a class="fixedBtn" href="../../../index.php">Back</a>

<!-- 引入jQuery1.12.4 -->
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<?= $jsScriptTag ?>

</body>

</html>