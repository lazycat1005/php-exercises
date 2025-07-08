<?php

class HtmlHelper
{
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

        $webRoot = '/PHP-Exercises/'; // 根目錄路徑
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
}
