---
mode: agent
---

# PHP-Exercises 練習題邏輯模組化指南

## 概述

本指南針對練習題中不同版本的 PHP 邏輯抽離與模組化，目標是在不影響原功能的前提下，將重複的業務邏輯整合到統一的控制器與驗證器中。

## 核心原則

- **最小影響**：僅抽離重複邏輯，不改變原有功能，不優化或新增其他無關的程式碼邏輯
- **向後相容**：保持現有文件路徑與介面不變
- **漸進式**：逐題目進行，降低風險

## 模組化架構

### 1. 目錄結構

```
app/
├── controller/           # 控制器層（業務邏輯）
│   ├── BaseController.php
│   ├── 08TemperatureController.php
│   ├── 19EnglishLettersController.php
│   ├── 27LeapYearController.php
│   ├── 34TelephoneBillController.php
│   ├── 47MultiplicationTableController.php
│   ├── 74TextLengthController.php
│   ├── 94FileMergerController.php
│   └── 97RemoveSpacesController.php
├── validator/            # 驗證器層
│   ├── BaseValidator.php
│   ├── 08TemperatureValidator.php
│   ├── 19EnglishLettersValidator.php
│   ├── 27LeapYearValidator.php
│   ├── 34TelephoneBillValidator.php
│   ├── 74TextLengthValidator.php
│   ├── 94FileMergerValidator.php
│   └── 97RemoveSpacesValidator.php
└── helper/               # 輔助函數
    └── HtmlHelper.php
```

### 2. 實施策略

#### 2.1 第一階段：建立基礎類別

- 創建 `BaseController` 與 `BaseValidator`
- 定義共用方法與介面
- 不影響現有文件

#### 2.2 第二階段：逐題目抽離

按題目優先級處理：

1. **溫度轉換 (08)** - 已有部分模組化基礎
2. **英文字母 (19)** - 邏輯簡單，適合測試
3. **閏年計算 (27)** - 單一版本，結構清晰
4. **電話費計算 (34)** - 複雜計算邏輯
5. **九九乘法表 (47)** - 已有 Helper 類別
6. **其他題目**

#### 2.3 第三階段：整合優化

- 統一錯誤處理
- 共用驗證規則
- 統一響應格式

## 具體實施步驟

### 步驟一：分析現有邏輯

對每個題目的不同版本進行邏輯分析：

```php
// 範例：溫度轉換邏輯分析
// version-php: 表單驗證 + 轉換計算 + 結果顯示
// version-ajax: AJAX 端點 + JSON 回應

// 共同邏輯：
// 1. 輸入驗證（數字、科學記號檢查）
// 2. 溫度轉換計算
// 3. 錯誤處理
```

### 步驟二：創建控制器類別

```php
// app/controller/08TemperatureController.php
<?php
class TemperatureController extends BaseController
{
    private $validator;

    public function __construct()
    {
        $this->validator = new TemperatureValidator();
    }

    public function convertTemperature($value, $fromUnit, $toUnit)
    {
        // 抽離共同的轉換邏輯
        $error = $this->validator->validateTemperature($value, $fromUnit);
        if ($error) {
            return ['success' => false, 'message' => $error];
        }

        $result = $this->calculateConversion($value, $fromUnit, $toUnit);
        return ['success' => true, 'result' => $result];
    }

    private function calculateConversion($value, $from, $to)
    {
        // 統一的轉換計算邏輯
    }
}
```

### 步驟三：創建驗證器類別

```php
// app/validator/08TemperatureValidator.php
<?php
class TemperatureValidator extends BaseValidator
{
    public function validateTemperature($value, $unit)
    {
        // 整合現有 utils/Validator.php 的邏輯
        // 添加更多驗證規則
    }
}
```

### 步驟四：修改現有文件

**保持最小修改原則**：

```php
// exercises/08_temperature-unit-conversion/version-php/index.php
<?php
// 原有代碼保持不變
$newCssName = '08temperature.css';
$metaKey = "temperature";
include '../../../header.php';

// 新增：引入控制器（可選，向後相容）
if (file_exists('../../../app/controller/08TemperatureController.php')) {
    require_once '../../../app/controller/08TemperatureController.php';
    $useController = true;
} else {
    // 保持原有邏輯作為 fallback
    require_once '../utils/Validator.php';
    $useController = false;
}
?>

<body>
    <!-- HTML 結構不變 -->

    <?php
    // 邏輯處理：使用控制器或原有邏輯
    if ($useController && !empty($_GET)) {
        $controller = new TemperatureController();
        $result = $controller->handleRequest($_GET);
        echo $result['html'];
    } else {
        // 原有的 PHP 邏輯保持不變
        // 這確保了向後相容性
    }
    ?>
</body>
```

## 各題目模組化重點

### 08 溫度轉換

- **抽離對象**：驗證邏輯、轉換計算、錯誤處理
- **版本差異**：PHP 表單 vs AJAX 端點
- **統一介面**：`convertTemperature($value, $fromUnit, $toUnit)`

### 19 英文字母

- **抽離對象**：字符驗證、ASCII 計算、類型判斷
- **版本差異**：不同輸入限制（僅大寫 vs 大小寫）
- **統一介面**：`analyzeCharacter($char, $mode)`

### 27 閏年計算

- **抽離對象**：年份驗證、閏年判斷、天數計算
- **版本特性**：單一版本，邏輯清晰
- **統一介面**：`calculateLeapYear($year)`

### 34 電話費計算

- **抽離對象**：時長驗證、費率計算、詳細說明
- **版本差異**：PHP 靜態 vs JS 互動（含歷史記錄）
- **統一介面**：`calculateBill($duration)`

### 47 九九乘法表

- **抽離對象**：輸入解析、表格生成、互動邏輯
- **版本差異**：靜態表格 vs 自定義 vs 互動遊戲
- **統一介面**：`generateTable($input, $mode)`

### 74 文字長度

- **抽離對象**：文字驗證、長度計算、限制檢查
- **版本差異**：PHP 提交 vs JS 即時 vs 限制輸入
- **統一介面**：`calculateTextLength($text, $limit)`

### 94 檔案合併

- **抽離對象**：檔案驗證、內容合併、下載生成
- **版本特性**：檔案處理邏輯
- **統一介面**：`mergeFiles($file1, $file2)`

### 97 移除空格

- **抽離對象**：字串處理、空格移除、結果返回
- **版本差異**：PHP 提交 vs JS 即時
- **統一介面**：`removeSpaces($string)`

## 注意事項

### 1. 向後相容性

- 保持原有文件結構
- 使用條件判斷載入新模組
- 原邏輯作為 fallback

### 2. 錯誤處理

- 統一錯誤訊息格式
- 保持原有使用者體驗
- 日誌記錄新增功能

### 3. 測試策略

- 每個模組獨立測試
- 確保功能一致性
- 效能影響評估

### 4. 逐步實施

- 一次處理一個題目
- 完成測試後再進行下一個
- 保持版本控制追蹤
