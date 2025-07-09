# PHP-EXERCISES

PHP 練習題，使用 jQuery1.12.4、SCSS、HTML、PHP

## 結構說明

```
PHP-EXERCISES/
├── app/                        # 專案 PHP 程式主體
│   ├── ajax/                   # AJAX 處理用 PHP
│   ├── config/                 # 設定檔
│   │   └── exercises.php
│   ├── Controller/             # 控制器
│   ├── Helper/                 # 輔助工具
│   └── Validator/              # 驗證器
├── assets/
│   ├── css/                    # 編譯後的全域與題目專用 CSS 樣式
│   ├── js/                     # 共用與題目專用 JavaScript 檔案
│   └── scss/                   # SCSS 原始檔 (含共用、題目專用、變數等)
├── exercises/                  # 各主題練習題目資料夾
│   ├── 04_lottery-app/
│   ├── 08_temperature-unit-conversion/
│   ├── 19_english-letter-case/
│   ├── 27_calculating-leap-years/
│   ├── 34_telephone-bill-calculation/
│   ├── 47_multiplication-table/
│   ├── 53_guess_number/
│   ├── 74_calculate-text-length/
│   ├── 94_file-merger/
│   └── 97_remove-spaces/
├── composer.json               # PHP 套件管理設定
├── index.php                   # 首頁
├── package.json                # 前端套件管理設定
├── vendor/                     # Composer 產生的 PHP 套件
└── README.md                   # 本說明文件
```

## 備註

- 每個練習項目以編號命名，方便區分與索引。
- 若有不同實作方式（如純 PHP vs AJAX），會分開放置於對應子資料夾中。

---
