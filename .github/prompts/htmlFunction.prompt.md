# Header/Footer 函數化重構計畫

## 現況分析

### 目前狀況

1. **Header 部分需要重構**：現有 `header.php` 使用 include 方式，不符合重構計畫的 HtmlHelper 模式
2. **Footer 部分重複性高**：每個練習題目都有相同的 footer 結構
3. **JavaScript 引入不一致**：部分頁面需要引入 JS，部分不需要
4. **CSS 載入方式不統一**：目前通過變數設定，應改為函數參數傳遞

### Header/Footer 結構分析

**目前 Header 問題**：
- 使用 `include '../../../header.php'` 方式
- 需要預先設定 `$metaKey` 和 `$newCssName` 變數
- 不符合重構計畫的 HtmlHelper 函數模式
- CSS 版本控制邏輯散落在 header.php 中

**目前 Footer 結構**：
- 固定的返回按鈕：`<a class="fixedBtn" href="../../../index.php">Back</a>`
- 可選的 JavaScript 引入（jQuery + 專用 JS）
- HTML 結束標籤：`</body></html>`

## 重構目標

1. **最小變動原則**：保持現有功能完全不變
2. **統一 Header/Footer 管理**：建立 HtmlHelper 函數處理重複程式碼
3. **符合重構計畫**：採用重構計畫中的 HtmlHelper 模式
4. **向後相容**：確保所有現有頁面正常運作

## 實施計畫

### 第一階段：建立 HtmlHelper 類別

#### 1.1 建立 `/app/helper/HtmlHelper.php`

```php
<?php
class HtmlHelper
{
    /**
     * 渲染頁面 Header
     * @param string $title 頁面標題
     * @param string $description 頁面描述
     * @param array $cssFiles CSS 檔案列表
     * @return string HTML Header 內容
     */
    public static function renderHeader($title, $description, $cssFiles = [])
    {
        $webRoot = '/PHP-Exercises/';
        $html = '<!DOCTYPE html>' . "\n";
        $html .= '<html lang="zh-TW">' . "\n\n";
        $html .= '<head>' . "\n";
        $html .= '    <meta charset="UTF-8">' . "\n";
        $html .= '    <meta name="viewport" content="width=device-width, initial-scale=1.0">' . "\n";
        $html .= '    <meta name="robots" content="index,follow">' . "\n";
        $html .= '    <meta name="googlebot" content="index,follow">' . "\n";
        $html .= '    <link rel="icon" sizes="192x192" href="#">' . "\n";
        $html .= '    <title>' . htmlspecialchars($title) . '</title>' . "\n";
        $html .= '    <meta name="description" content="' . htmlspecialchars($description) . '">' . "\n";
        
        // 永遠先載入 all.css
        $allCssPath = __DIR__ . '/../../assets/css/all.css';
        $allCssUrl = $webRoot . 'assets/css/all.css';
        if (file_exists($allCssPath)) {
            $allCssVer = filemtime($allCssPath);
            $allCssUrl .= '?v=' . $allCssVer;
        }
        $html .= '    <link rel="stylesheet" href="' . htmlspecialchars($allCssUrl) . '">' . "\n";
        
        // 載入額外的 CSS 檔案
        foreach ($cssFiles as $cssFile) {
            $cssPath = __DIR__ . '/../../assets/css/' . $cssFile;
            $cssUrl = $webRoot . 'assets/css/' . $cssFile;
            if (file_exists($cssPath)) {
                $cssVer = filemtime($cssPath);
                $cssUrl .= '?v=' . $cssVer;
            }
            $html .= '    <link rel="stylesheet" href="' . htmlspecialchars($cssUrl) . '">' . "\n";
        }
        
        $html .= '</head>' . "\n";
        
        return $html;
    }

    /**
     * 渲染頁面 Footer
     * @param array $jsFiles JavaScript 檔案列表（可選）
     * @param string $backUrl 返回按鈕連結（預設：../../../index.php）
     * @return string HTML Footer 內容
     */
    public static function renderFooter($jsFiles = [], $backUrl = '../../../index.php')
    {
        $html = '';
        
        // 返回按鈕
        $html .= sprintf('    <a class="fixedBtn" href="%s">Back</a>' . "\n", htmlspecialchars($backUrl));
        
        // JavaScript 檔案引入
        if (!empty($jsFiles)) {
            $html .= "\n";
            foreach ($jsFiles as $jsFile) {
                $html .= sprintf('    <script src="%s"></script>' . "\n", htmlspecialchars($jsFile));
            }
        }
        
        // HTML 結束標籤
        $html .= '</body>' . "\n\n" . '</html>';
        
        return $html;
    }
}
```

#### 1.2 題目 metadata 獲取方式

建立輔助函數來獲取題目資訊：

```php
<?php
class HtmlHelper
{
    // ...existing code...

    /**
     * 根據 metaKey 獲取題目資訊
     * @param string $metaKey 題目識別碼
     * @return array 包含 title 和 description 的陣列
     */
    public static function getExerciseInfo($metaKey)
    {
        $metaArr = require __DIR__ . '/../../config/exercises.php';
        return [
            'title' => $metaArr[$metaKey]['title'] ?? '',
            'description' => $metaArr[$metaKey]['description'] ?? ''
        ];
    }
}
```

#### 1.3 JavaScript 引入模式分析

根據現有檔案，JavaScript 引入模式為：
1. **jQuery 1.12.4**：`https://code.jquery.com/jquery-1.12.4.min.js`
2. **專用 JS**：`/PHP-Exercises/assets/js/[題目編號][題目名稱].js`

### 第二階段：逐步更新現有檔案

#### 2.1 更新策略

**最小變動原則**：
- 只修改 footer 部分
- 保持現有的 header 引入方式不變
- 保持所有功能邏輯不變

#### 2.2 檔案修改範圍

需要更新的檔案類型：

1. **純 PHP 頁面**（無 JavaScript）
   - `exercises/27_calculating-leap-years/version-php/index.php`
   - `exercises/34_telephone-bill-calculation/version-php/index.php`
   - `exercises/47_multiplication-table/version-1/index.php`
   - `exercises/74_calculate-text-length/version-1/index.php`
   - `exercises/74_calculate-text-length/version-3/index.php`
   - `exercises/94_file-merger/version-php/index.php`
   - `exercises/97_remove-spaces/version-php/index.php`
   - 等其他純 PHP 版本

2. **含 JavaScript 頁面**
   - `exercises/08_temperature-unit-conversion/version-ajax/index.php`
   - `exercises/19_english-letter-case/version-2/index.php`
   - `exercises/19_english-letter-case/version-4/index.php`
   - `exercises/34_telephone-bill-calculation/version-js/index.php`
   - `exercises/47_multiplication-table/version-2/index.php`
   - `exercises/47_multiplication-table/version-3/index.php`
   - `exercises/74_calculate-text-length/version-2/index.php`
   - `exercises/74_calculate-text-length/version-4/index.php`
   - `exercises/97_remove-spaces/version-js/index.php`

#### 2.3 修改前後對比

**修改前**（目前的方式）：
```php
<?php
$newCssName = '27leapYear.css';
$metaKey = "leap-years";
include '../../../header.php';
?>

<body>
    <!-- 頁面內容 -->
    <a class="fixedBtn" href="../../../index.php">Back</a>
</body>

</html>
```

**修改後**（HtmlHelper 方式）：
```php
<?php
require_once '../../../app/helper/HtmlHelper.php';

// 獲取題目資訊
$exerciseInfo = HtmlHelper::getExerciseInfo('leap-years');

// 渲染 Header
echo HtmlHelper::renderHeader(
    $exerciseInfo['title'],
    $exerciseInfo['description'],
    ['27leapYear.css']
);
?>

<body>
    <!-- 頁面內容 -->
    
<?php
// 渲染 Footer
echo HtmlHelper::renderFooter();
?>
```

**含 JavaScript 版本修改前**：
```php
<?php
$newCssName = '08temperature.css';
$metaKey = "temperature";
include '../../../header.php';
?>

<body>
    <!-- 頁面內容 -->
    
    <a class="fixedBtn" href="../../../index.php">Back</a>

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="/PHP-Exercises/assets/js/08temperature.js"></script>
</body>

</html>
```

**含 JavaScript 版本修改後**：
```php
<?php
require_once '../../../app/helper/HtmlHelper.php';

$exerciseInfo = HtmlHelper::getExerciseInfo('temperature');

echo HtmlHelper::renderHeader(
    $exerciseInfo['title'],
    $exerciseInfo['description'],
    ['08temperature.css']
);
?>

<body>
    <!-- 頁面內容 -->
    
<?php
echo HtmlHelper::renderFooter([
    'https://code.jquery.com/jquery-1.12.4.min.js',
    '/PHP-Exercises/assets/js/08temperature.js'
]);
?>
```

### 第三階段：測試與驗證

#### 3.1 功能測試

1. **頁面載入測試**：確認所有頁面正常載入
2. **樣式測試**：確認 fixedBtn 樣式正常顯示
3. **JavaScript 功能測試**：確認需要 JS 的頁面功能正常
4. **連結測試**：確認返回按鈕正常跳轉

#### 3.2 檔案檢查

1. **路徑正確性**：確認所有相對路徑正確
2. **HTML 結構完整性**：確認沒有標籤遺漏
3. **功能完整性**：確認所有原有功能保持不變

## 實施順序

### 優先級 1：建立基礎結構
1. 建立完整的 `HtmlHelper.php`（包含 renderHeader 和 renderFooter）
2. 選擇 1-2 個檔案進行測試

### 優先級 2：批量更新
1. 更新所有純 PHP 版本（風險較低）
2. 更新含 JavaScript 版本（需仔細核對 JS 路徑）

### 優先級 3：驗證與清理
1. 全面功能測試
2. 移除舊的 `header.php` 檔案
3. 程式碼清理

### 優先級 4：完善化
1. 效能檢查
2. 文件更新

## 預期效益

### 維護效益
1. **統一管理**：Header/Footer 結構集中管理，易於維護
2. **減少重複**：消除 header/footer 相關重複程式碼
3. **符合架構**：完全符合重構計畫的 HtmlHelper 模式
4. **擴展性佳**：未來新增功能更容易

### 開發效益
1. **一致性**：所有頁面 header/footer 結構統一
2. **易於修改**：修改 header/footer 只需更新一個檔案
3. **參數化設計**：通過函數參數靈活控制 CSS/JS 載入
4. **降低錯誤**：減少手動複製貼上可能的錯誤

## 注意事項

1. **保持現有功能**：確保不破壞任何現有功能
2. **路徑處理**：注意相對路徑的正確性，特別是 HtmlHelper 中的路徑計算
3. **CSS 載入順序**：確保 all.css 永遠先載入，再載入專用 CSS
4. **JavaScript 順序**：確保 JavaScript 載入順序正確（jQuery 先載入）
5. **向後相容**：完成重構後可移除舊的 `header.php`
6. **metadata 路徑**：確認 exercises.php 的相對路徑正確

---

_此重構計畫將 Header 和 Footer 都改為 HtmlHelper 函數模式，完全符合重構指南，以最小變動為原則，專注於消除重複程式碼，提升專案維護性。_
