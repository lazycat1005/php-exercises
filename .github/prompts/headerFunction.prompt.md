---
mode: agent
---

# Header 函數化改造指南

## 概述

我們已將 `header.php` 的功能整合到 `app/helper/HtmlHelper.php` 中，現在需要修改所有 exercises 資料夾中的 index.php 檔案，改用新的函數化方式來輸出 HTML header。

## 新的 HtmlHelper 使用方式

### 函數簽名

```php
HtmlHelper::renderHeader(string $metaKey = 'temperature', string $newCssName = 'main.css')
```

### 參數說明

- `$metaKey`：metadata 鍵值，用於讀取標題和描述（預設：'temperature'）
- `$newCssName`：專用 CSS 檔名（預設：'main.css'）

## 修改步驟

### 1. 舊的寫法（需要修改）

```php
<?php
// 設定 metadata 和 CSS 檔名
$metaKey = "temperature";
$newCssName = "08temperature.css";

// 引入 header
require_once __DIR__ . '/../../header.php';
?>
```

### 2. 新的寫法（目標格式）

```php
<?php
// 引入 HtmlHelper
require_once __DIR__ . '/../../app/helper/HtmlHelper.php';

// 使用 HtmlHelper 輸出 header
HtmlHelper::renderHeader('temperature', '08temperature.css');
?>
```

## 修改範例

### 範例 1：溫度單位轉換（08_temperature-unit-conversion）

**修改前：**

```php
<?php
$metaKey = "temperature";
$newCssName = "08temperature.css";
require_once __DIR__ . '/../../header.php';
?>
```

**修改後：**

```php
<?php
require_once __DIR__ . '/../../app/helper/HtmlHelper.php';
HtmlHelper::renderHeader('temperature', '08temperature.css');
?>
```

### 範例 2：英文字母大小寫（19_english-letter-case）

**修改前：**

```php
<?php
$metaKey = "englishLetters";
$newCssName = "19englishLetters.css";
require_once __DIR__ . '/../../header.php';
?>
```

**修改後：**

```php
<?php
require_once __DIR__ . '/../../app/helper/HtmlHelper.php';
HtmlHelper::renderHeader('englishLetters', '19englishLetters.css');
?>
```

### 範例 3：電話費計算（34_telephone-bill-calculation）

**修改前：**

```php
<?php
$metaKey = "telephoneBill";
$newCssName = "34telephoneBill.css";
require_once __DIR__ . '/../../header.php';
?>
```

**修改後：**

```php
<?php
require_once __DIR__ . '/../../app/helper/HtmlHelper.php';
HtmlHelper::renderHeader('telephoneBill', '34telephoneBill.css');
?>
```

## 注意事項

1. **路徑調整**：確保 `require_once` 的路徑正確指向 `HtmlHelper.php`
2. **參數對應**：第一個參數是原本的 `$metaKey`中所存放的字串，第二個參數是 CSS 檔名
3. **CSS 檔名**：確保 CSS 檔名與實際檔案名稱一致
4. **metadata 鍵值**：確保 metaKey 在 `app/config/exercises.php` 中有對應的設定
