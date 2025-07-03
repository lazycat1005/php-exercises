# PHP-Exercises 專案重構計畫

## 專案現況分析

### 目前問題

1. **代碼重複性高**：每個版本都有重複的 HTML 結構、CSS 樣式和 JavaScript 邏輯
2. **結構混亂**：每個練習題目獨立分散，缺乏統一的架構
3. **維護困難**：修改共用功能需要在多個檔案中重複修改
4. **缺乏一致性**：各版本間的實作方式不統一
5. **資源浪費**：重複載入相同的 CSS 和 JS 檔案

### 重構目標

1. **模組化架構**：建立可重用的組件系統
2. **統一風格**：建立一致的設計系統和程式碼風格
3. **提升維護性**：減少重複代碼，集中管理共用邏輯
4. **改善效能**：優化資源載入和檔案結構
5. **增強擴展性**：建立易於新增練習題目的架構

## 重構方案

### Phase 1: 基礎架構重構

#### 1.1 建立核心目錄結構

```
PHP-Exercises/
├── app/                      # 應用程式核心
│   ├── controller/           # 控制器層
│   │   ├── BaseController.php
│   │   ├── 08temperatureController.php
│   │   ├── 19englishLettersController.php
│   │   ├── 27leapYearController.php
│   │   ├── 34telephoneBillController.php
│   │   ├── 47multiplicationTableController.php
│   │   ├── 74textLengthController.php
│   │   ├── 94fileMergerController.php
│   │   └── 97removeSpacesController.php
│   ├── validator/            # 驗證器層
│   │   ├── BaseValidator.php # 基底驗證器
│   │   ├── 08temperatureValidator.php
│   │   ├── 19englishLettersValidator.php
│   │   ├── 27leapYearValidator.php
│   │   ├── 34telephoneBillValidator.php
│   │   ├── 74textLengthValidator.php
│   │   ├── 94fileMergerValidator.php
│   │   └── 97removeSpacesValidator.php
│   ├── helper/               # 輔助函數
│   │   ├── HtmlHelper.php    # HTML 生成輔助器(header/footer function)
│   │   ├── StringHelper.php  # 字串處理輔助器
│   │   └── FileHelper.php    # 檔案處理輔助器
│   └── config/               # 設定檔
│       ├── exercises.json    # 練習題目路徑設定(從根目錄移入)
│       └── app.php           # 應用程式基本設定
├── assets/                   # 靜態資源
│   ├── scss/                          # SCSS 原始檔
│   │   ├── _variables.scss            # 變數定義
│   │   ├── _reset.scss                # CSS 重設
│   │   ├── _common.scss               # 重複性極高的共用樣式
│   │   ├── all.scss                   # 主要入口檔案
│   │   ├── 08temperature.scss         # 溫度轉換專用樣式
│   │   ├── 19englishLetters.scss      # 英文字母轉換專用樣式
│   │   ├── 27leapYear.scss            # 閏年計算專用樣式
│   │   ├── 34telephoneBill.scss       # 電話帳單專用樣式
│   │   ├── 47multiplicationTable.scss # 九九乘法表專用樣式
│   │   ├── 74textLength.scss          # 文字長度計算專用樣式
│   │   ├── 94fileMerger.scss          # 檔案合併專用樣式
│   │   └── 97removeSpaces.scss        # 移除空格專用樣式
│   ├── css/                           # 編譯後的 CSS
│   │   ├── all.css                    # 全域樣式(每個頁面都會引入)
│   │   ├── 08temperature.css          # 溫度轉換專用樣式
│   │   ├── 19englishLetters.css       # 英文字母轉換專用樣式
│   │   ├── 27leapYear.css             # 閏年計算專用樣式
│   │   ├── 34telephoneBill.css        # 電話帳單專用樣式
│   │   ├── 47multiplicationTable.css  # 九九乘法表專用樣式
│   │   ├── 74textLength.css           # 文字長度計算專用樣式
│   │   ├── 94fileMerger.css           # 檔案合併專用樣式
│   │   └── 97removeSpaces.css         # 移除空格專用樣式
│   ├── js/                            # JavaScript 檔案
│   │   ├── common.js                  # 共用 JavaScript 功能
│   │   ├── 08temperature.js           # 溫度轉換專用腳本
│   │   ├── 19englishLetters.js        # 英文字母轉換專用腳本
│   │   ├── 27leapYear.js              # 閏年計算專用腳本
│   │   ├── 34telephoneBill.js         # 電話帳單專用腳本
│   │   ├── 47multiplicationTable.js   # 九九乘法表專用腳本
│   │   ├── 74textLength.js            # 文字長度計算專用腳本
│   │   ├── 94fileMerger.js            # 檔案合併專用腳本
│   │   └── 97removeSpaces.js          # 移除空格專用腳本
│   └── images/               # 圖片資源(如有需要)
├── exercises/                # 練習題目(保持現有結構)
│   ├── 08_temperature/       # 溫度轉換
│   │   ├── version-php/
│   │   ├── version-ajax/
│   │   └── version-ai/
│   ├── 19_english-letters/   # 英文字母轉換
│   │   ├── version-1/
│   │   ├── version-2/
│   │   ├── version-3/
│   │   └── version-4/
│   ├── 27_leap-years/        # 閏年計算
│   │   ├── version-php/
│   │   └── version-ai/
│   ├── 34_telephone-bill/    # 電話帳單
│   │   ├── version-php/
│   │   ├── version-js/
│   │   └── version-ai/
│   ├── 47_multiplication-table/ # 九九乘法表
│   │   ├── version-1/
│   │   ├── version-2/
│   │   └── version-3/
│   ├── 74_text-length/       # 文字長度計算
│   │   ├── version-1/
│   │   ├── version-2/
│   │   ├── version-3/
│   │   └── version-4/
│   ├── 94_file-merger/       # 檔案合併
│   │   └── version-php/
│   └── 97_remove-spaces/     # 移除空格
│       ├── version-js/
│       └── version-php/
├── index.php                 # 入口檔案
└── .htaccess                 # Apache 設定
```

#### 1.2 CSS 架構說明

##### 雙 CSS 檔案引入策略

每個練習題目頁面都會引入兩隻 CSS 檔案：

1. **all.css** (全域樣式)

   - CSS Reset (\_reset.scss)
   - 變數定義 (\_variables.scss)
   - 重複性極高的共用樣式 (\_common.scss)
   - 固定按鈕、導覽、表單基礎樣式等

2. **\[題目編號].css** (專用樣式)
   - 每個練習題目的專屬樣式
   - 統一放在 `/assets/css/` 目錄
   - 如：08temperature.css、34telephoneBill.css

##### SCSS 結構

```scss
// all.scss
@import "variables"; // 顏色、字體、間距變數
@import "reset"; // CSS 重設
@import "common"; // 共用樣式(按鈕、表單、卡片等)

// 各題目專用 SCSS 檔案
// 08temperature.scss、34telephoneBill.scss 等
```

#### 1.3 Header/Footer 函數化

使用 `HtmlHelper.php` 中的函數來處理重複的 header 和 footer：

```php
// 在各版本的 index.php 中使用
<?php
require_once '../../app/helper/HtmlHelper.php';
echo HtmlHelper::renderHeader($title, $description, $cssFiles);
?>

<!-- 頁面內容 -->

<?php
echo HtmlHelper::renderFooter($jsFiles);
?>
```

#### 1.4 JSON 路徑管理

將 `exercises.json` 移到 `/app/config/` 目錄，保持現有的 JSON 結構：

```json
{
  "08_temperature": {
    "title": "溫度轉換",
    "description": "將溫度從攝氏度轉換為華氏度，或從華氏度轉換為攝氏度。",
    "css": "08temperature.css",
    "js": "08temperature.js",
    "versions": {
      "php": "./exercises/08_temperature/version-php/",
      "ajax": "./exercises/08_temperature/version-ajax/",
      "ai": "./exercises/08_temperature/version-ai/"
    }
  }
}
```

#### 1.5 重構後的頁面載入流程

```html
<!-- 每個練習題目的 index.php 結構 -->
<!DOCTYPE html>
<html lang="zh-TW">
  <head>
    <!-- 通過 HtmlHelper 動態生成 -->
    <link rel="stylesheet" href="/assets/css/all.css" />
    <link rel="stylesheet" href="/assets/css/08temperature.css" />
  </head>
  <body>
    <!-- 頁面內容 -->

    <!-- 通過 HtmlHelper 動態生成 -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="/assets/js/common.js"></script>
    <script src="/assets/js/08temperature.js"></script>
  </body>
</html>
```

### Phase 2: 重構實施階段

#### 2.1 檔案遷移階段

1. **建立新的目錄結構**
2. **遷移 exercises.json 到 app/config/**
3. **整合所有練習題目的 CSS 到 assets/css/**
4. **整合所有練習題目的 JS 到 assets/js/**

#### 2.2 CSS 重構階段

1. **建立 all.scss 主檔案**
   - 合併現有的重複樣式
   - 建立變數系統
   - 統一 CSS Reset
2. **建立各題目專用 SCSS 檔案**
   - 將每個題目原本在 css/main.scss 的內容遷移
   - 統一命名規則

#### 2.3 PHP 函數化階段

1. **建立 HtmlHelper**
   - renderHeader () 函數
   - renderFooter () 函數
   - 支援動態 CSS/JS 載入
2. **更新所有 index.php 檔案**
   - 使用新的 HtmlHelper 函數
   - 移除重複的 HTML 代碼

#### 2.4 測試與驗證階段

1. **逐一測試每個練習題目**
2. **確認樣式正確載入**
3. **確認功能正常運作**

### Phase 3: 後續擴展規劃

#### 3.1 進階功能 (未來可選)

- Controller 層的實作
- Validator 層的實作
- 更複雜的路由系統

#### 3.2 效能優化 (未來可選)

- CSS/JS 壓縮
- 快取機制
- 圖片優化

## 重構效益

### 開發效益

1. **CSS 統一管理**：不再散落在各題目資料夾
2. **減少重複代碼**：Header/Footer 函數化
3. **易於維護**：集中管理靜態資源
4. **開發效率提升**：新增題目時只需專注於邏輯

### 學習效益

1. **循序漸進**：不會一次過於複雜
2. **實用為主**：專注於解決現有問題
3. **易於理解**：保持簡單的架構
4. **擴展性佳**：未來可以逐步加入更多功能

## 實施建議

### 第一階段：檔案結構調整

- 建立新目錄
- 遷移 CSS/JS 檔案
- 更新 JSON 設定

### 第二階段：CSS 整合

- 建立 all.scss
- 建立各題目專用 CSS
- 測試樣式載入

### 第三階段：PHP 函數化

- 功能測試

### 第四階段：完善與測試

- 全面測試
- 效能檢查
- 文件更新
- 建立 HtmlHelper
- 更新所有頁面

---

_此重構計畫以簡化為主，專注於解決當前最重要的問題：CSS 管理、重複代碼減少，以及檔案結構優化。適合 PHP 初學者循序漸進地學習專案重構。_
