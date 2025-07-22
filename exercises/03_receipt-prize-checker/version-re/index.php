<!DOCTYPE html>
<html lang="zh-TW">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>網頁標題</title>
    <meta name="description" content="網頁簡介">

</head>

<body>
    <header>
        <h1>發票對獎系統</h1>
        <p>114年3~4月發票對獎器</p>
    </header>

    <main>
        <form method="get">
            <label for="receipt">請輸入發票號碼：</label>
            <input type="number" id="receipt" name="receipt" required>
            <button type="submit">查詢</button>
        </form>
        <div class="messageText">
            <?php

            // 取得中獎規則
            function getPrizeRules()
            {
                return [
                    'special' => [ // 特別獎：1000萬（8碼全中）
                        'label' => '特別獎',
                        'amount' => 10000000,
                        'numbers' => ['64557267'], // 實際中獎號碼
                    ],
                    'grand' => [ // 特獎：200萬（8碼全中）
                        'label' => '特獎',
                        'amount' => 2000000,
                        'numbers' => ['64808075'], // 實際中獎號碼
                    ],
                    'first' => [ // 頭獎：8碼全中
                        'label' => '頭獎',
                        'amount' => 200000,
                        'numbers' => ['04322277', '07903676', '98883497'],
                    ],
                    'additional' => [ // 增開六獎：末3碼
                        'label' => '增開六獎',
                        'amount' => 200,
                        'numbers' => ['', ''], // 末3碼中獎
                    ],
                    'matching' => [ // 對中幾碼的對應獎金（僅適用於頭獎落空但對到後面幾碼）
                        7 => ['label' => '貳獎', 'amount' => 40000],
                        6 => ['label' => '參獎', 'amount' => 10000],
                        5 => ['label' => '肆獎', 'amount' => 4000],
                        4 => ['label' => '伍獎', 'amount' => 1000],
                        3 => ['label' => '陸獎', 'amount' => 200],
                    ],
                ];
            }


            //驗證函數(使用正則表達式)，使用者可輸入3~8位數字，但不可含有字串與浮點數、正負號，若驗證失敗返回false
            function validateReceipt($receipt)
            {

                return preg_match('/^\d{3,8}$/', $receipt);
            }
            ?>
        </div>
    </main>
</body>

</html>