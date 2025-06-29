<?php
$metaKey = "telephone";
$exerciseDir = __DIR__ . '/../';
include '../../../header.php';
?>

<body>
    <main id="phpVersion" class="container">
        <section class="introduction">
            <h1>電話費計算器</h1>
            <ul>
                <li>600 分鐘以下每分鐘 0.5 元</li>
                <li>600~1200 分鐘電話費以 9 折計算</li>
                <li>1200 分鐘以上電話費以 79 折計算</li>
            </ul>
        </section>

        <form action="" method="get">
            <fieldset id="telephoneBillCalculation">
                <label for="callDuration">通話時長（分鐘）:</label>
                <input type="number" id="callDuration" name="callDuration" step="any" min="0" max="44640" required>

                <button type="submit">計算電話費</button>
            </fieldset>
        </form>

        <section class="result">
            <h2>這個月的電話帳單詳細為:</h2>
            <?php
            if (isset($_GET['callDuration'])) {
                $callDuration = $_GET['callDuration'] ?? 0;

                // 檢查通話時長是否為正整數，並且不是科學符號，如"1e10"
                if (!is_numeric($callDuration) || $callDuration < 0 || preg_match('/e/i', $callDuration)) {
                    echo "<p>請輸入有效的通話時長。</p>";
                } else {
                    // 計算電話費
                    if ($callDuration <= 600) {
                        $billAmount = $callDuration * 0.5;
                    } elseif ($callDuration <= 1200) {
                        // 前600分鐘應該以原價計算，超過的部分才是0.5*0.9
                        $billAmount = 600 * 0.5 + ($callDuration - 600) * 0.5 * 0.9;
                    } else {
                        // 前600分鐘應該以原價計算，600~1200分鐘內是0.5*0.9，超過1200分鐘後才是0.5*0.79
                        $billAmount = 600 * 0.5 + (1200 - 600) * 0.5 * 0.9 + ($callDuration - 1200) * 0.5 * 0.79;
                    }
                    // 將詳細電話費進算輸出給用戶，例如用戶輸入了1300分鐘，則輸出600分鐘的原價，600~1200分鐘的9折計算，以及1200分鐘以上的79折計算
                    echo "<p>通話時長: {$callDuration} 分鐘</p>";
                    echo "<p>計算過程:</p>";
                    echo "<ul>";
                    if ($callDuration <= 600) {
                        echo "<li>前 600 分鐘: " . number_format($callDuration * 0.5, 2) . " 元</li>";
                    } else {
                        echo "<li>前 600 分鐘: " . number_format(600 * 0.5, 2) . " 元</li>";
                    }

                    if ($callDuration > 600 && $callDuration <= 1200) {
                        echo "<li>超過 600 未滿 1200 分鐘: " . number_format(($callDuration - 600) * 0.5 * 0.9, 2) . " 元</li>";
                    } elseif ($callDuration > 1200) {
                        echo "<li>超過 600 未滿 1200 分鐘: " . number_format(600 * 0.5 * 0.9, 2) . " 元</li>";
                    }

                    if ($callDuration > 1200) {
                        echo "<li>超過 1200 分鐘以上: " . number_format(($callDuration - 1200) * 0.5 * 0.79, 2) . " 元</li>";
                    }
                    echo "</ul>";
                    // 輸出總金額
                    echo "<p>總金額為 NT$ " . number_format($billAmount, 2) . "</p>";
                    // 應繳金額為正整數，小數點計算方式應為四捨五入
                    echo "<h3>應繳金額為 NT$ " . round($billAmount) . "</h3>";
                }
            }
            ?>
        </section>

    </main>

    <a class="fixedBtn" href="../../../index.php">Back</a>
</body>

</html>