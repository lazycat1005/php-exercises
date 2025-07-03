---
mode: agent
---

# JS 搬移重構指南

## 概述

本指南說明如何將分散在各練習題目資料夾中的 JavaScript 檔案，統一整合到 `/assets/js/` 目錄中，達到模組化管理，避免命名衝突並提升可維護性。

**注意**：JS 的搬移與 CSS 不同，並非每個 `index.php` 都有對應的 JS，且不同題目裡的版本可能有重複檔名 (`app.js`)。請一次僅針對一個練習題目資料夾進行搬移，確保變更可追蹤與測試。

## 目標結構

重構後的檔案結構：
```
assets/
└── js/
    ├── common.js                 # 共用函式與邏輯
    ├── 08temperature.js          # 溫度轉換專用腳本
    ├── 19englishLetters.js       # 英文字母大小寫專用腳本
    └── ... 其他題目專用腳本
```

並在各題目對應的 `index.php` 中，統一引入：
```html
<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
<script src="/PHP-Exercises/assets/js/common.js"></script>
<script src="/PHP-Exercises/assets/js/[題目編號][英文簡稱].js"></script>
```

## 重構步驟

### Step 1: 準備目錄
```bash
# 在專案根目錄執行
mkdir -p assets/js
```

### Step 2: 處理共用腳本
- 如果尚未有 `/assets/js/common.js`，請新建之，並將專案中多處共用函式（如 AJAX 呼叫封裝、驗證函式等）彙整到此檔案。

### Step 3: 搬移題目專屬腳本
以溫度轉換 (08) 為例：

1. **複製原始內容**
   - 找出 `exercises/08_temperature-unit-conversion/version-*/app.js`（或 `js/app.js`）檔案內容。
2. **建立新檔案**
   ```bash
touch assets/js/08temperature.js
```  
3. **搬移程式碼**
   - 將原本 `app.js` 的程式邏輯貼至 `assets/js/08temperature.js`。
   - 移除 `<script>` 標籤相關的路徑與載入程式碼。
4. **更新 `index.php`**
   - 刪除舊有相對路徑的 `<script src="./app.js"></script>`。  
   - 在 jQuery 之後，插入：
     ```html
     <script src="/PHP-Exercises/assets/js/common.js"></script>
     <script src="/PHP-Exercises/assets/js/08temperature.js"></script>
     ```
5. **移除舊檔案**
   - 刪除 `exercises/08_temperature-unit-conversion/.../app.js` 或 `js/app.js`，以免混淆。

### Step 4: 處理命名衝突
- 若不同版本或題目有相同變數或函式名稱，請在移入前加上命名空間或函式封裝：
  ```javascript
  // 例如：
  var TempModule = (function () {
    function convert() { /* ... */ }
    return { convert };
  })();
  ```

### Step 5: 測試與驗證
1. 打開對應 `index.php` 測試功能是否正常。  
2. 在瀏覽器檢查 Console 確認無 404 或錯誤訊息。  

### Step 6: 紀錄與提交
- 完成後請參考 [.copilot-commit-message-instructions.md] 撰寫 commit 註解，範例：
```
[modify] 搬移 08temperature.js 至 assets/js，並更新 index.php 引入路徑
[fixbug] 修正 TempModule 命名空間衝突
```  
- 並將本次搬移記錄加入 `/.github/historyLog/log_{YYYY-MM-DD}.md`。  

---
*以上僅示範一個題目，請依照相同步驟完成其他練習題目的 JS 重構。*
