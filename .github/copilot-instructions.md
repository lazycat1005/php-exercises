# 專案介紹

此專案是用於練習 php 7.3 與 jQuery 1.12.4 的練習題專案，用以練習語法上的操作與物件化概念、模組化架構專案。

本專案利用創建子資料夾的方式，將不同練習題區隔開，每個題目可能有多個版本 (version-xx)，在題目資料夾中有一個 `README.md` 檔案用以說明該題目內容。

## 代碼風格

### 整體代碼規範

- 前後端的輸入驗證應該一致，例如前端的驗證包含禁止小數點、後端的驗證規則就該包含禁止小數點。
- 所有代碼規範盡量符合 clean code 的原則，不同功能的邏輯區塊盡可能用 function 或 class 來區隔，避免所有邏輯混雜在一塊，提高可閱讀性。
- MVC 架構：此專案並非嚴格遵守 MVC 架構所建立，但仍然會盡量將邏輯分離，讓程式碼更易於維護。
  - `app/Controllers/`：放置後端的所有控制器，需符合 PSR-4 命名規範。
  - `app/Helper/`：放置共用的輔助函式，如生成頁面的 header 與 footer，不放置單一練習題的視圖生成檔案，需符合 PSR-4 命名規範。
  - `app/Validator/`：放置後端所有驗證器，需符合 PSR-4 命名規範。另外驗證器的寫法應該只回傳布林值，錯誤訊息請使用 try/catch 來處理。
  - `app/Views/`：放置所有的視圖檔案，需符合 PSR-4 命名規範。
  - `assets/js`: 放置各練習題的 JavaScript 檔案，命名規則為 `[題目編號][題目名稱].js`。
  - `exercises/[題目編號][題目名稱]/[版本]/index.php`:主要頁面呈現，所有的視圖邏輯應該在這裡統一處理。

### PHP

- 所有代碼規範盡量符合 clean code 的原則，不同功能的邏輯區塊盡可能用 function 或 class 來區隔，避免所有邏輯混雜在一塊，提高可閱讀性。
- 請遵循 PSR-12 代碼風格指南，並且使用空格來縮排程式碼。
- 不使用 `<?= ?>` 簡寫語法，請改為完整語法 `<?php echo ?>`。
- ob_start(); 跟 ob_get_clean() 非必要不要使用，改用字串串接。
- 非必要不要使用 static function ，除非是工具函式。

### jQuery (JavaScript)

- 所有代碼規範盡量符合 clean code 的原則，不同功能的邏輯區塊盡可能用 function 或 class 來區隔，避免所有邏輯混雜在一塊，提高可閱讀性。
- 請遵循 jQuery 1.12.4 的語法規範，並且使用 ES2015+ 語法。
- 不要使用 `var` 來定義變數，請使用 `let` 。
- 只有在確認變數不會變動的情況下，才使用 `const`來定義變數。
- 請在變數前加上$符號，例如 `$variableName`，以符合 jQuery 的命名慣例。
- 請使用 `===` 來比較值，避免使用 `==`，以確保類型安全。
- 使用傳統函數（非箭頭函數）定義邏輯時，保持無狀態，避免依賴 this。
- 使用 AJAX 時，請使用 fetch API 或 await/async。
- 防抖函數與節流函數已寫進 common.js 中，請直接使用。

### SCSS (CSS)

- 使用巢狀語法，並且使用 `&` 符號來引用父選擇器。
- 請使用 `px` 作為單位。
- `.fixedBtn` 樣式已經寫入 `all.css` 檔案中，請不用針對這個 class 做任何修改或新增其他樣式
- 使用駝峰式命名法命名 class 與 id，但不使用 BEM 命名法，僅用簡單易懂的名稱即可。

### HTML

- 除非必要否則不寫行內樣式，這會導致行內樣式權重過高，在進行版型調整時可能會遇到困難。

## 檔案結構與載入策略

- **雙 JavaScript 檔案引入策略**：每個練習題目頁面都會引入兩隻 JS 檔案
  1. `/assets/js/common.js` (共用功能) - 包含全域函數、共用邏輯等
  2. `/assets/js/[題目編號][題目名稱].js` (專用腳本) - 如 `08temperature.js`、`34telephoneBill.js`

#### 開發規則

- **新增 JavaScript 功能**：
  - 共用功能請在 `/assets/js/common.js` 中撰寫
  - 題目專用邏輯請在 `/assets/js/[題目編號][題目名稱].js` 中撰寫

#### 檔案命名規則

- 題目專用 JS 檔案命名：`[題目編號][題目名稱].js` (如：`08temperature.js`)
- 所有 JavaScript 檔案統一放置在 `/assets/js/` 目錄

### SCSS (CSS)

#### 檔案結構與載入策略

- **雙 CSS 檔案引入策略**：每個練習題目頁面都會引入兩隻 CSS 檔案
  1. `/assets/css/all.css` (全域樣式) - 包含 CSS Reset、變數定義、共用樣式等
  2. `/assets/css/[題目編號][題目名稱].css` (專用樣式) - 如 `08temperature.css`、`34telephoneBill.css`

#### 開發規則

- **新增 CSS 樣式**：

  - 共用樣式請修改 `/assets/scss/_common.scss`
  - 題目專用樣式請在 `/assets/scss/[題目編號][題目名稱].scss` 中撰寫
  - 變數定義請在 `/assets/scss/_variables.scss` 中管理

#### 檔案命名規則

- 題目專用 SCSS 檔案命名：`[題目編號][題目名稱].scss` (如：`08temperature.scss`)
- 編譯後的 CSS 檔案會自動產生在 `/assets/css/` 目錄

## 生成紀錄

- 每日創建一個新的 `log_{YYYY-MM-DD}.md` 檔案於 `/.github/historyLog/` 資料夾中，並在檔案命稱後面加上日期，若檔案已存在則不要覆蓋，僅需寫入，讓下一位繼任者了解你修改了什麼，好方便接續的工作。

## 注意事項

- 所有的表單資料輸入皆需要嚴謹的前後端驗證流程，且前後端驗證規則應一致，以防止惡意攻擊或注入攻擊等情況。

- 生成 git commit 時，請參考 [.copilot-commit-message-instructions.md](.copilot-commit-message-instructions.md) 中的指示，並且使用中文。
