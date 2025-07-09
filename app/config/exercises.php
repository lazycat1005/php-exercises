<?php
// exercises.php
// 練習題目設定檔，原本為 JSON 格式，現改為 PHP 多維陣列

return [
    'temperature' => [
        'title' => '溫度轉換',
        'description' => '將溫度從攝氏度轉換為華氏度，或從華氏度轉換為攝氏度。',
        'links' => [
            'ajax' => './exercises/08_temperature-unit-conversion/version-ajax/',
            'php' => './exercises/08_temperature-unit-conversion/version-php/',
        ],
    ],
    'telephone' => [
        'title' => '電話帳單',
        'description' => '計算電話帳單的費用，根據通話時間和費率進行計算。',
        'links' => [
            'php' => './exercises/34_telephone-bill-calculation/version-php/',
            'js' => './exercises/34_telephone-bill-calculation/version-js/',
        ],
    ],
    'leapYears' => [
        'title' => '閏年計算',
        'description' => '判斷給定的年份是否為閏年，並計算該年度總天數。',
        'links' => [
            'php' => './exercises/27_calculating-leap-years/version-php/',
        ],
    ],
    'englishLetters' => [
        'title' => '英文字母轉換',
        'description' => '將使用者輸入的英文字母轉換為大寫或小寫。',
        'links' => [
            'v-1' => './exercises/19_english-letter-case/version-1/',
            'v-2' => './exercises/19_english-letter-case/version-2/',
            'v-3' => './exercises/19_english-letter-case/version-3/',
            'v-4' => './exercises/19_english-letter-case/version-4/',
        ],
    ],
    'multiplicationTable' => [
        'title' => '九九乘法表',
        'description' => '生成九九乘法表，顯示從1到9的乘法結果。',
        'links' => [
            'v-1' => './exercises/47_multiplication-table/version-1/',
            'v-2' => './exercises/47_multiplication-table/version-2/',
            'v-3' => './exercises/47_multiplication-table/version-3/',
        ],
    ],
    'mergeFiles' => [
        'title' => '合併檔案',
        'description' => '將兩個TXT檔案的內容合併為一個TXT檔案，並顯示下載鏈結。',
        'links' => [
            'php' => './exercises/94_file-merger/version-php/',
        ],
    ],
    'textLength' => [
        'title' => '計算文字長度',
        'description' => '計算使用者輸入的文字長度，並顯示結果。',
        'links' => [
            'v-1' => './exercises/74_calculate-text-length/version-1/',
            'v-2' => './exercises/74_calculate-text-length/version-2/',
            'v-3' => './exercises/74_calculate-text-length/version-3/',
            'v-4' => './exercises/74_calculate-text-length/version-4/',
        ],
    ],
    'removeSpaces' => [
        'title' => '刪除字串空格',
        'description' => '刪除使用者輸入字串中的所有空格，並顯示處理後的結果。',
        'links' => [
            'php' => './exercises/97_remove-spaces/version-php/',
            'js' => './exercises/97_remove-spaces/version-js/',
        ],
    ],
    'lotteryApp' => [
        'title' => '樂透彩模擬APP',
        'description' => '隨機產生樂透號碼，並顯示結果。',
        'links' => [
            'php' => './exercises/04_lottery-app/version-php/'
        ],
    ],
    'guessNumber' => [
        'title' => '猜數字遊戲',
        'description' => '使用者猜測1~100的隨機數字，並提供提示。',
        'links' => [
            'version-php' => './exercises/53_guess_number/version-php/',
            'version-js' => './exercises/53_guess_number/version-js/',
        ],
    ]
];
