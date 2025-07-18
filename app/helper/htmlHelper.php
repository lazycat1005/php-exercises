<?php

namespace App\Helper;

class HtmlHelper
{
    public static function getWebRoot(): string
    {
        $scriptName = $_SERVER['SCRIPT_NAME'] ?? '';
        if (!empty($scriptName)) {
            $pathInfo = pathinfo($scriptName);
            $dir = $pathInfo['dirname'] ?? '';
            $segments = explode('/', trim($dir, '/'));
            $rootSegments = [];

            foreach ($segments as $segment) {
                $rootSegments[] = $segment;
                $testPath = $_SERVER['DOCUMENT_ROOT'] . '/' . implode('/', $rootSegments) . '/assets';
                if (is_dir($testPath)) {
                    return '/' . implode('/', $rootSegments) . '/';
                }
            }
        }

        // 最終 fallback
        return '/PHP-Exercises/';
    }

    /**
     * 輸出 HTML header 區塊
     * @param string $metaKey metadata key，預設 temperature
     * @param string $newCssName 專用 CSS 檔名，預設 main.css
     */
    public static function renderHeader(string $metaKey = 'temperature', string $newCssName = 'main.css')
    {
        // 讀取 metadata，改為讀取 PHP 設定檔
        $metaArr = require __DIR__ . '/../config/exercises.php';
        $title = $metaArr[$metaKey]['title'] ?? '';
        $desc = $metaArr[$metaKey]['description'] ?? '';

        // $webRoot = '/PHP-Exercises/'; // 根目錄路徑
        $webRoot = self::getWebRoot();
        // 設定 css 路徑
        $cssRealPath =  __DIR__ . '/../../assets/css/' . $newCssName;
        $cssUrlPath = $webRoot . 'assets/css/' . $newCssName;
        $allCssRealPath = __DIR__ . '/../../assets/css/all.css';
        $allCssUrlPath = $webRoot . 'assets/css/all.css';

        if (file_exists($cssRealPath)) {
            $cssVer = filemtime($cssRealPath);
            $cssUrlPath .= '?v=' . $cssVer;
        }

        if (file_exists($allCssRealPath)) {
            $allCssVer = filemtime($allCssRealPath);
            $allCssUrlPath .= '?v=' . $allCssVer;
        }
?>
        <!DOCTYPE html>
        <html lang="zh-TW">

        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <meta name="robots" content="index,follow">
            <meta name="googlebot" content="index,follow">
            <link rel="icon" sizes="192x192" href="#">
            <title><?= htmlspecialchars($title) ?></title>
            <meta name="description" content="<?= htmlspecialchars($desc) ?>">
            <link rel="stylesheet" href="<?= htmlspecialchars($cssUrlPath) ?>">
            <link rel="stylesheet" href="<?= htmlspecialchars($allCssUrlPath) ?>">
        </head>

        <body>
        <?php
    }

    /**
     * 輸出 HTML footer 區塊，包含 jQuery 及專屬 JS 檔案引入
     * @param string $jsFileName 專屬 JS 檔案名稱，預設空字串
     */
    public static function renderFooter(string $jsFileName = '')
    {
        // 設定Web根目錄路徑
        // $webRoot = '/PHP-Exercises/';
        $webRoot = self::getWebRoot();


        // 處理專屬JavaScript檔案引入
        $jsScriptTag = '';
        if (!empty($jsFileName)) {
            $jsRealPath = __DIR__ . '/../../assets/js/' . $jsFileName;
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
<?php
    }
}
