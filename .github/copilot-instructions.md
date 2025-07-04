# 專案介紹

此專案是用於練習 php 7.3 與 jQuery 1.12.4 的練習題專案。

利用創建子資料夾的方式，將不同練習題目區隔開，每個題目都會有多個版本 (子資料夾)，並且會有一個 `README.md` 檔案來說明題目的內容。

另外也會將重複的程式碼抽出來，練習模組化與物件化。

## 代碼風格

### PHP

- 請遵循 PSR-12 代碼風格指南，並且使用空格來縮排程式碼。

### jQuery (JavaScript)

#### 版本與語法規範

- 此專案使用 jQuery 1.12.4 版本
- 撰寫 jQuery 程式碼時，請遵循 JavaScript ES2015+ 語法，不要再使用 var 來定義變數

#### 檔案結構與載入策略

- **雙 JavaScript 檔案引入策略**：每個練習題目頁面都會引入兩隻 JS 檔案
  1. `/assets/js/common.js` (共用功能) - 包含全域函數、共用邏輯等
  2. `/assets/js/[題目編號][題目名稱].js` (專用腳本) - 如 `08temperature.js`、`34telephoneBill.js`

#### 開發規則

- **新增 JavaScript 功能**：
  - 共用功能請在 `/assets/js/common.js` 中撰寫
  - 題目專用邏輯請在 `/assets/js/[題目編號][題目名稱].js` 中撰寫
  - 確保 jQuery 1.12.4 已經載入後再執行自定義腳本

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

- **SCSS 語法規範**：
  - 撰寫 SCSS 時，請注意在 `all.css` 檔案中已經使用 `html {font-size: 62.5%;}`，因此在使用 rem 單位時，1rem = 10px，預設字體 16px 會變成 1.6rem 才對，否則 1rem 的字體會變顯得過小，不容易閱讀
  - 字體大小與間距請使用 `rem` 單位，但是陰影與圓角請使用 `px` 單位
  - `.fixedBtn` 樣式已經寫入 `all.css` 檔案中，請不用針對這個 class 做任何修改

#### 檔案命名規則

- 題目專用 SCSS 檔案命名：`[題目編號][題目名稱].scss` (如：`08temperature.scss`)
- 編譯後的 CSS 檔案會自動產生在 `/assets/css/` 目錄

## 生成紀錄

- 每日創建一個新的 `log_{YYYY-MM-DD}.md` 檔案於 `/.github/historyLog/` 資料夾中，並在檔案命稱後面加上日期，若檔案已存在則不要覆蓋，僅需寫入，讓下一位繼任者了解你修改了什麼，好方便接續的工作。。

## 注意事項

- 所有使用者的資料輸入皆需要嚴謹的前後端驗證流程，以防止惡意攻擊或注入攻擊等情況。

- 生成 git commit 時，請參考 [.copilot-commit-message-instructions.md](.copilot-commit-message-instructions.md) 中的指示，並且使用中文。
