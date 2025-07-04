---
mode: agent
---

# JavaScript 檔案合併指南

## 目標

將每個練習題資料夾中不同版本的 `app.js` 抽出並合併成統一的 JS 檔案，以便維護管理。合併過程中僅解決 JS 衝突問題，不進行大幅度變更或過度優化。

## 合併策略

### 1. 檔案結構規劃

#### 保持現有的雙檔案載入策略

- `/PHP-Exercises/assets/js/common.js` - 共用功能檔案
- `/PHP-Exercises/assets/js/[題目編號][題目名稱].js` - 題目專用檔案

#### 新增檔案

- 建立 `/assets/js/common.js`（如果不存在）
- 為每個題目建立對應的專用檔案

### 2. 合併原則

#### 2.1 最小變更原則

- 保持原有程式邏輯不變
- 僅解決命名衝突和重複程式碼問題
- 不進行功能優化或重構

#### 2.2 衝突處理策略

**變數命名衝突**

```javascript
// 原始程式碼（可能衝突）
const errorMessage = $(".messageText p");

// 解決方案：加上題目前綴
const temp08ErrorMessage = $(".messageText p");
```

**函數命名衝突**

```javascript
// 原始程式碼（可能衝突）
function validateInput() { ... }

// 解決方案：加上題目前綴
function validateTemp08Input() { ... }
```

**選擇器衝突**

- 保持原有選擇器不變（因為每個題目頁面有獨立的 HTML 結構）
- 僅在必要時添加更具體的選擇器

#### 2.3 程式碼組織

**共用功能識別**
以下類型的程式碼應放入 `common.js`：

- 通用的表單驗證函數
- 共用的錯誤處理機制
- 重複出現的 jQuery 擴展功能
- 通用的工具函數

**題目專用功能**

- 特定於某個題目的業務邏輯
- 特定的事件處理器
- 特定的 AJAX 請求處理

### 3. 合併步驟

#### 步驟 1：分析現有檔案

1. 列出所有 `app.js` 檔案位置
2. 分析每個檔案的功能和依賴
3. 識別共用功能和專用功能
4. 檢查潛在的命名衝突

#### 步驟 2：建立共用檔案

1. 建立 `/assets/js/common.js`
2. 抽取共用功能到 `common.js`
3. 確保向後相容性

#### 步驟 3：建立題目專用檔案

1. 為每個題目建立專用 JS 檔案
2. 合併同一題目的不同版本
3. 解決版本間的衝突
4. 保持最完整的功能版本

#### 步驟 4：更新引用

1. 更新每個題目頁面的 JS 引用
2. 確保載入順序正確（common.js 先載入）
3. 測試所有功能正常運作
4. 需要在路徑上添加 `/PHP-Exercises/` 前綴，以確保正確載入。

### 4. 具體執行計畫

#### 4.1 題目檔案對應表

| 題目編號 | 題目名稱                    | 目標檔案名稱             | 現有版本                        |
| -------- | --------------------------- | ------------------------ | ------------------------------- |
| 08       | temperature-unit-conversion | 08temperature.js         | version-ajax, version-php       |
| 19       | english-letter-case         | 19englishLetters.js      | version-2, version-4            |
| 34       | telephone-bill-calculation  | 34telephoneBill.js       | version-js                      |
| 47       | multiplication-table        | 47multiplicationTable.js | version-2, version-3            |
| 74       | calculate-text-length       | 74textLength.js          | version-1, version-2, version-4 |
| 97       | remove-spaces               | 97removeSpaces.js        | version-js                      |

#### 4.2 衝突解決範例

**題目 08：溫度轉換**

```javascript
// 合併 version-ajax 和 version-php 的功能
// 保留 AJAX 版本的完整功能
// 添加版本識別機制

$(document).ready(function () {
  // 檢查是否為 AJAX 版本（根據頁面元素判斷）
  const isAjaxVersion = $("#ajaxForm").length > 0;

  if (isAjaxVersion) {
    // AJAX 版本的程式碼
    handleAjaxTemperatureConversion();
  } else {
    // PHP 版本的程式碼
    handlePhpTemperatureConversion();
  }
});
```

**題目 47：乘法表**

```javascript
// 合併 version-2 和 version-3 的驗證邏輯
$(document).ready(function () {
  // 共用的表單驗證邏輯
  $("#tableForm").on("submit", function (e) {
    // 合併兩個版本的驗證規則
    if (!validateMultiplicationInput($("#tableCount").val())) {
      e.preventDefault();
    }
  });
});
```

### 5. 品質保證

#### 5.1 測試檢查清單

- [ ] 所有題目頁面載入正常
- [ ] 所有 JavaScript 功能運作正常
- [ ] 沒有 console 錯誤
- [ ] 表單驗證功能正常
- [ ] AJAX 請求正常運作
- [ ] 錯誤訊息顯示正確

#### 5.2 回歸測試

每個題目都需要測試：

1. 正常輸入情況
2. 異常輸入情況
3. 邊界值測試
4. 錯誤處理測試

### 6. 檔案維護規範

#### 6.1 新增功能時

- 評估是否為共用功能
- 共用功能加入 `common.js`
- 專用功能加入對應的題目檔案

#### 6.2 修改現有功能時

- 確認影響範圍
- 更新對應的檔案
- 進行回歸測試

#### 6.3 命名規範

- 共用函數：`common[FunctionName]()`
- 題目專用函數：`[題目編號][FunctionName]()`
- 變數：使用有意義的名稱，避免過於簡短

### 7. 注意事項

#### 7.1 jQuery 版本相容性

- 確保所有程式碼相容 jQuery 1.12.4
- 避免使用新版本的 jQuery 特性
- 使用 ES2015+ 語法但避免使用 `var`

#### 7.2 效能考慮

- 避免重複的 DOM 查詢
- 適當使用快取機制
- 保持程式碼簡潔

#### 7.3 向後相容性

- 確保合併後的檔案不會破壞現有功能
- 保留所有必要的事件處理器
- 維持原有的錯誤處理邏輯

### 8. 實施時程

1. **第一階段**：分析和規劃

- 完成檔案分析
- 確定合併策略
- 建立檔案對應表

2. **第二階段**：建立共用檔案

- 建立 `common.js`
- 抽取共用功能

3. **第三階段**：合併題目檔案

- 逐個題目進行合併
- 解決衝突問題
- 進行功能測試

4. **第四階段**：整合測試

- 全面測試所有功能
- 修復發現的問題
- 文件更新

### 9. 成果驗收

#### 9.1 技術指標

- 所有題目頁面正常載入
- JavaScript 功能完整保留
- 沒有控制台錯誤
- 檔案結構清晰

#### 9.2 維護性指標

- 程式碼重複度降低
- 檔案組織更清晰
- 新功能添加更容易
- 問題定位更快速

此指南確保在最小變更的前提下完成 JavaScript 檔案合併，提升專案的可維護性。
