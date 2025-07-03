---
mode: agent
---

# CSS/SCSS 搬移重構指南

## 概述

本指南說明如何將現有分散在各練習題目中的 CSS/SCSS 檔案，重構整合到統一的 `/assets/` 目錄結構中，實現模組化管理。

我會指示本次要重構的`[題目編號][題目英文簡稱]`資料夾，**一次只做一個練習題目資料夾的搬移**，以確保每次變更都能清楚追蹤和測試。請勿改動我未指示的`[題目編號][題目英文簡稱]`資料夾。

## 重構目標

1. **統一管理**：將所有 CSS/SCSS 檔案集中在 `/assets/` 目錄
2. **模組化設計**：採用雙 CSS 檔案引入策略，一為固定的`all.css`另一個為該題目專屬的 CSS 檔案
3. **提升維護性**：建立一致的檔案命名和組織結構，範例:`[題目編號][題目英文簡稱]`
4. **不更動內容**：只將目前的 css 與 scss 檔案搬移至新目錄路徑下，不需要做任何優化與增加程式碼

## 檔案結構規劃

### 重構前結構

```
exercises/
├── 08_temperature-unit-conversion/
│   └── css/
│       ├── main.css
│       ├── main.css.map
│       └── main.scss
├── 34_telephone-bill-calculation/
│   └── css/
│       ├── main.css
│       ├── main.css.map
│       └── main.scss
└── ...其他題目
```

### 重構後結構

```
assets/
├── scss/                          # SCSS 原始檔
│   ├── _variables.scss            # 變數定義
│   ├── _reset.scss                # CSS 重設
│   ├── _common.scss               # 共用樣式
│   ├── all.scss                   # 主要入口檔案
│   ├── 08temperature.scss         # 溫度轉換專用樣式
│   ├── 34telephoneBill.scss       # 電話帳單專用樣式
│   └── ...其他題目專用樣式
└── css/                           # 編譯後的 CSS
    ├── all.css                    # 全域樣式
    ├── 08temperature.css          # 溫度轉換專用樣式
    ├── 34telephoneBill.css        # 電話帳單專用樣式
    └── ...其他題目專用樣式
```

## 重構步驟

### Step 1: 建立基礎目錄結構

```bash
# 在專案根目錄執行
mkdir -p assets/scss
mkdir -p assets/css
```

### Step 2: 建立核心 SCSS 檔案

#### 2.1 建立變數檔案 `_variables.scss`

- 暫時為空檔案

#### 2.2 建立重設檔案 `_reset.scss`，從`/css/all.scss`中搬移出來

```scss
/* CSS Reset */
* {
  box-sizing: border-box;
  margin: 0;
  padding: 0;
  // outline: 1px solid limegreen !important;
  // background: rgb(0 100 0 /0.05) !important;
}

html {
  font-size: 62.5%;
}

a {
  text-decoration: none;
  transition: all 0.3s;
}

ul,
ol {
  list-style: none;
}
```

#### 2.3 建立共用樣式 `_common.scss`

- 暫時為空檔案

#### 2.4 建立主入口檔案 `all.scss`

```scss
// 匯入順序很重要
@import "variables";
@import "reset";
@import "common";
```

### Step 3: 題目專用樣式遷移

#### 3.1 檔案命名規則

| 原始檔案路徑                                             | 新檔案路徑                          | 檔案名稱規則                    |
| -------------------------------------------------------- | ----------------------------------- | ------------------------------- |
| `exercises/08_temperature-unit-conversion/css/main.scss` | `assets/scss/08temperature.scss`    | `[題目編號][題目英文簡稱].scss` |
| `exercises/34_telephone-bill-calculation/css/main.scss`  | `assets/scss/34telephoneBill.scss`  | `[題目編號][題目英文簡稱].scss` |
| `exercises/19_english-letter-case/css/main.css`          | `assets/scss/19englishLetters.scss` | `[題目編號][題目英文簡稱].scss` |

#### 3.2 題目名稱對照表

| 題目編號 | 題目名稱                    | 檔案後綴            | 完整檔案名                 |
| -------- | --------------------------- | ------------------- | -------------------------- |
| 08       | temperature-unit-conversion | temperature         | 08temperature.scss         |
| 19       | english-letter-case         | englishLetters      | 19englishLetters.scss      |
| 27       | calculating-leap-years      | leapYear            | 27leapYear.scss            |
| 34       | telephone-bill-calculation  | telephoneBill       | 34telephoneBill.scss       |
| 47       | multiplication-table        | multiplicationTable | 47multiplicationTable.scss |
| 74       | calculate-text-length       | textLength          | 74textLength.scss          |
| 94       | file-merger                 | fileMerger          | 94fileMerger.scss          |
| 97       | remove-spaces               | removeSpaces        | 97removeSpaces.scss        |

#### 3.3 遷移步驟範例

以溫度轉換 (08) 為例：

1. **複製原始檔案內容**

   ```bash
   # 檢視原始檔案
   cat exercises/08_temperature-unit-conversion/css/main.scss
   ```

2. **建立新的 SCSS 檔案**

   ```bash
   touch assets/scss/08temperature.scss
   ```

3. **遷移樣式內容**

   - 移除重複的重設樣式 (已在 `_reset.scss` 中)
   - 保留題目專屬的樣式
   - 在 `exercises\08_temperature-unit-conversion\version-ajax\index.php` 與 `exercises\08_temperature-unit-conversion\version-php\index.php`中加入加入變數`$newCssName ='08temperature.css'`

   ```php
   $newCssName = '08temperature.css'; //添加此行
   $exerciseDir = __DIR__ . '/../';
   include '../../../header.php';
   ```

### Step 4: SCSS 編譯設定

搬移完後不需要執行 scss 編譯指令
