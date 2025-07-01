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
│   │   ├── Temperature08Controller.php
│   │   ├── EnglishLetters19Controller.php
│   │   ├── LeapYear27Controller.php
│   │   ├── TelephoneBill34Controller.php
│   │   ├── MultiplicationTable47Controller.php
│   │   ├── TextLength74Controller.php
│   │   ├── FileMerger94Controller.php
│   │   └── RemoveSpaces97Controller.php
│   ├── validator/            # 驗證器層
│   │   ├── BaseValidator.php # 基底驗證器
│   │   ├── Temperature08Validator.php
│   │   ├── EnglishLetters19Validator.php
│   │   ├── LeapYear27Validator.php
│   │   ├── TelephoneBill34Validator.php
│   │   ├── TextLength74Validator.php
│   │   ├── FileMerger94Validator.php
│   │   └── RemoveSpaces97Validator.php
│   ├── helper/               # 輔助函數
│   │   ├── HtmlHelper.php    # HTML 生成輔助器
│   │   ├── StringHelper.php  # 字串處理輔助器
│   │   └── FileHelper.php    # 檔案處理輔助器
│   └── config/               # 設定檔
│       └── routes.php        # 路由設定
├── assets/                   # 靜態資源
│   ├── scss/                 # SCSS 原始檔
│   │   ├── _variables.scss   # 變數、混入、函數
│   │   ├── _reset.scss       # 基礎樣式
│   │   └── all.scss          # 主要入口檔案
│   ├── css/                  # 編譯後的 CSS
│   │   ├── all.css
│   │   └── all.css.map
│   ├── js/                   # JavaScript 檔案
│   │   ├── temperature08.js
│   │   ├── englishLetters19.js
│   │   ├── leapYear27.js
│   │   ├── telephoneBill34.js
│   │   ├── multiplicationTable47.js
│   │   ├── textLength74.js
│   │   ├── fileMerger94.js
│   │   └── removeSpaces97.js
├── exercises/                # 練習題目
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
├── index.php             # 入口檔案
└──  .htaccess             # Apache 設定
```
