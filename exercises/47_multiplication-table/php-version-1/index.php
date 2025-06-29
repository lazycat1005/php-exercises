<?php
$metaKey = "multiplication-table";
$exerciseDir = __DIR__ . '/../';
include '../../../header.php';
require_once '../../../lib/MultiplicationTableHelper.php';

use Lib\MultiplicationTableHelper;

?>

<body>
    <main>
        <h1>九九乘法表</h1>

        <section>
            <h2>九九乘法表（3欄×3列的大表格，每格為5欄×9列的乘法子表格）</h2>
            <table class="outer">
                <?php
                $colsPerRow = 3;
                $rows = 3;
                $tablesPerCell = 5;

                // 使用物件取得預設表格
                $tableNumbers = MultiplicationTableHelper::parseTableInput('9');

                for ($row = 0; $row < $rows; $row++) {
                    echo "<tr>";
                    for ($col = 0; $col < $colsPerRow; $col++) {
                        echo "<td>";
                        echo "<table class='inner'>";
                        // 9 列
                        for ($i = 1; $i <= 9; $i++) {
                            echo "<tr>";
                            $base = $row * $colsPerRow + $col + 1;
                            if ($base <= 9) {
                                $result = $base * $i;
                                echo "<td>{$base} × {$i} = {$result}</td>";
                            } else {
                                echo "<td>&nbsp;</td>";
                            }
                            for ($empty = 1; $empty < $tablesPerCell; $empty++) {
                                echo "<td>&nbsp;</td>";
                            }
                            echo "</tr>";
                        }
                        echo "</table>";
                        echo "</td>";
                    }
                    echo "</tr>";
                }
                ?>
            </table>
        </section>
    </main>

    <a class="fixedBtn" href="../../../index.php">Back</a>
</body>

</html>