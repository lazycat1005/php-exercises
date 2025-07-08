---
mode: agent
---

# index.php footer 區塊轉換指南

## 目標

將每個練習題目資料夾（exercises/xxx/）下的 index.php 檔案，原本直接寫在檔案底部的 footer（包含 jQuery、回首頁按鈕、專屬 JS 檔案引入等），統一改為呼叫 `HtmlHelper::renderFooter()` 函數。

---

## 步驟說明

1. **移除原本 footer 舊寫法**

- 找到檔案底部，正常情況下應該為以下兩種情況，分為有`$jsFileName`與沒有的狀況：

  ```php
  <?php include '../../../footer.php'; ?>
  ```

  ```php
  <?php
  $jsFileName = '[題目編號][題目名稱].js';
  include '../../../footer.php';
  ?>
  ```

2. **改為呼叫 HtmlHelper::renderFooter()**

- 在移除的地方加上

  ```php
  <?php HtmlHelper::renderFooter('[原jsFileName]'); ?>
  ```

- `[專屬 JS 檔名]` 請依照原本的`$jsFileName`設定，切勿更改成其他名稱，若沒有`$jsFileName`則使用`HtmlHelper::renderFooter()`即可。
