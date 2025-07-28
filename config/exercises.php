<?php

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
        'title' => 'ASCII 分析英文字母',
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
            'version-php' => './exercises/53_guess-number/version-php/',
            'version-js' => './exercises/53_guess-number/version-js/',
        ],
    ],
    'numbersToChinese' => [
        'title' => '數字轉中文單位',
        'description' => '將阿拉伯數字轉換為中文單位表示法，例如「1234」轉為「一千二百三十四」。',
        'links' => [
            'version-php' => './exercises/29_numbers-to-chinese/version-php/',
        ],
    ],
    'perpetualCalendar' => [
        'title' => '萬年曆產生器',
        'description' => '讓使用者輸入西元年與月份，印出該月份的月曆。',
        'links' => [
            'version-php' => './exercises/84_perpetual-calendar/version-php/',
        ],
    ],
    "receiptPrizeChecker" => [
        'title' => '發票對獎',
        'description' => '使用者輸入發票號碼，檢查是否中獎。',
        'links' => [
            'version-php' => './exercises/03_receipt-prize-checker/version-php/',
        ],
    ],
    "takeAwayGame" => [
        'title' => '取火柴遊戲',
        'description' => '一個簡單的取火柴遊戲，玩家可以選擇取走1到3根火柴。',
        'links' => [
            'version-js' => './exercises/54_take-away-game/version-js/',
        ],
    ],
    "constellations" => [
        'title' => '星座與生肖',
        'description' => '根據使用者輸入的生日，顯示對應的星座和生肖。',
        'links' => [
            'version-php' => './exercises/33_constellations/version-php/',
            'version-js' => './exercises/33_constellations/version-js/',
        ],
    ],
    "binary" => [
        'title' => '計算多少個1',
        'description' => '將使用者輸入的二進位數字轉換為十進位數字，並計算其中有多少個1。',
        'links' => [
            'version-php-1' => './exercises/96_binary/version-php-1/',
            'version-php-2' => './exercises/96_binary/version-php-2/',
            'version-js-1' => './exercises/96_binary/version-js-1/',
            'version-js-2' => './exercises/96_binary/version-js-2/',
        ],
    ],
    "customAddition" => [
        'title' => '自訂加法',
        'description' => '實現一個自訂的加法功能，允許使用者輸入兩個數字並計算其和。',
        'links' => [
            'version-php' => './exercises/69_custom-addition/version-php/',
            'version-js' => './exercises/69_custom-addition/version-js/',
        ],
    ],
    "randomNumberProbability" => [
        'title' => '隨機數字機率',
        'description' => '使用者輸入最小值、最大值和間隔，計算在1萬次迴圈中每個數字出現的機率。',
        'links' => [
            'version-php' => './exercises/101_random-number-probability/version-php/',
            'version-js' => './exercises/101_random-number-probability/version-js/',
        ],
    ],
];
