---
mode: agent
---

# Footer 重構指南

## 概述

本指南旨在重構 exercises 資料夾內各個 index.php 檔案的 footer 部分，將重複的程式碼抽出成獨立的 `footer.php` 檔案，類似於現有的 `header.php` 的模式。

## 目標

1. 抽離重複的 footer 程式碼
2. 統一管理 JavaScript 引入
3. 為 JavaScript 檔案添加版本號
4. 保持現有功能不變

## 需要抽離的元素

### 1. 固定返回按鈕

```html
<a class="fixedBtn" href="../../../index.php">Back</a>
```

### 2. jQuery 引入

```html
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
```

### 3. 專屬 JavaScript 檔案引入（有條件的）

```html
<script src="/PHP-Exercises/assets/js/[題目編號][題目名稱].js"></script>
```

### 4. HTML 結束標籤

```html
</body>
</html>
```

## Footer.php 設計規範

### 檔案位置

- 檔案路徑：`/footer.php`（與 header.php 同層級）

### 設計原則

1. **條件式 JavaScript 引入**

- 透過設定變數 `$jsFileName` 來決定是否引入專屬 JS 檔案
- 如果未設定 `$jsFileName`，則不引入專屬 JS 檔案

2. **版本號管理**

- 為專屬 JavaScript 檔案添加版本號（基於檔案修改時間）
- 格式：`?v={filemtime}`

3. **路徑管理**

- 使用相對路徑或絕對路徑確保在不同層級目錄下都能正確引入

### Footer.php 架構設計

```php
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
```

## 各練習題目的修改規範

### 在每個 index.php 檔案中的修改

1. **在檔案開頭設定變數**（緊接在 header 引入之後）

```php
<?php
$newCssName = '[題目編號][題目名稱].css';
$metaKey = "[metadata-key]";
$jsFileName = '[題目編號][題目名稱].js'; // 新增此行
include '../../../header.php';
```

2. **移除原有 footer 部分**

- 移除 `<a class="fixedBtn">` 標籤
- 移除 jQuery 引入
- 移除專屬 JS 檔案引入
- 移除 `</body>` 和 `</html>` 標籤

3. **在檔案結尾引入 footer**

```php
<?php include '../../../footer.php'; ?>
```

### 特殊情況處理

1. **沒有專屬 JavaScript 檔案的練習**

- 不設定 `$jsFileName` 變數
- 或設定為空字串：`$jsFileName = '';`

2. **不同版本的處理**

- 每個版本資料夾的 index.php 都需要單獨修改
- 確保路徑相對性正確

## 實作步驟

### 階段一：建立 footer.php

1. 創建 `/footer.php` 檔案
2. 實作上述設計的 footer 架構
3. 測試基本功能

### 階段二：修改現有檔案

1. 依序修改各練習題目的 index.php
2. 每修改一個檔案就進行測試
3. 確保功能正常運作

### 階段三：驗證與測試

1. 測試所有練習題目頁面
2. 確認 JavaScript 功能正常
3. 確認返回按鈕功能正常
4. 檢查版本號是否正確添加

## 預期效果

1. **程式碼重用性**：減少重複程式碼
2. **維護性提升**：統一管理 footer 相關功能
3. **版本控制**：JavaScript 檔案自動添加版本號
4. **一致性**：所有頁面 footer 格式統一

## 注意事項

1. **路徑檢查**：確保在不同層級目錄下路徑都正確
2. **檔案存在性檢查**：JavaScript 檔案不存在時不引入
3. **向後相容性**：不破壞現有功能
4. **測試充分性**：每個修改都要進行功能測試

## 檔案清單（需要修改的檔案）

根據現有結構，需要修改的 index.php 檔案包括：

1. `/exercises/08_temperature-unit-conversion/version-php/index.php`
2. `/exercises/08_temperature-unit-conversion/version-ajax/index.php`
3. `/exercises/19_english-letter-case/version-1/index.php`
4. `/exercises/19_english-letter-case/version-2/index.php`
5. `/exercises/19_english-letter-case/version-3/index.php`
6. `/exercises/19_english-letter-case/version-4/index.php`
7. `/exercises/27_calculating-leap-years/index.php`（如果存在）
8. `/exercises/34_telephone-bill-calculation/index.php`（如果存在）
9. `/exercises/47_multiplication-table/index.php`（如果存在）
10. `/exercises/53_guess_number/index.php`（如果存在）
11. `/exercises/74_calculate-text-length/index.php`（如果存在）
12. `/exercises/94_file-merger/index.php`（如果存在）
13. `/exercises/97_remove-spaces/index.php`（如果存在）

## JavaScript 檔案對應表

| 練習題目                       | JavaScript 檔案名稱      |
| ------------------------------ | ------------------------ |
| 08_temperature-unit-conversion | 08temperature.js         |
| 19_english-letter-case         | 19englishLetters.js      |
| 34_telephone-bill-calculation  | 34telephoneBill.js       |
| 47_multiplication-table        | 47multiplicationTable.js |
| 53_guess_number                | 53guessNumber.js         |
| 74_calculate-text-length       | 74textLength.js          |
| 97_remove-spaces               | 97removeSpaces.js        |
