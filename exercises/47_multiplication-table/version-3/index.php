<?php
$newCssName = '47multiplicationTable.css';
$metaKey = "multiplication-table";
include '../../../header.php';
require_once '../../../lib/MultiplicationTableHelper.php';

use Lib\MultiplicationTableHelper;
?>

<body>
    <main>
        <h1>九九乘法表</h1>

        <section>
            <form method="get" action="" id="tableForm">
                <label for="tableCount">請輸入要產生哪些乘法表（例如：1~8、2、4,6,9、1~2,6,9）：</label>
                <input type="text" id="tableCount" name="tableCount" autocomplete="off"
                    pattern="^[0-9,，~\- ]+$"
                    value="<?php echo isset($_GET['tableCount']) ? htmlspecialchars($_GET['tableCount']) : '9'; ?>">
                <button type="submit">產生</button>
                <span id="inputError" style="color:red;margin-left:1em;"></span>
            </form>
        </section>

        <section>
            <h2>九九乘法表互動小遊戲（依序作答，答對才可輸入下一題）</h2>
            <table class="outer">
                <?php
                $colsPerRow = 3;
                $rows = 3;
                $tablesPerCell = 5;

                $input = isset($_GET['tableCount']) ? $_GET['tableCount'] : '9';
                $showError = false;
                if (isset($_GET['tableCount']) && !MultiplicationTableHelper::isValidInput($input)) {
                    $showError = true;
                    echo "<script>window.inputErrorMsg = '請勿輸入文字、科學符號、運算符號、小數點或超過9的數字';</script>";
                } else {
                    echo "<script>window.inputErrorMsg = '';</script>";
                }

                $tableNumbers = (!$showError) ? MultiplicationTableHelper::parseTableInput($input) : [];
                if (empty($tableNumbers) && !$showError) {
                    $tableNumbers = [9];
                }

                // 產生互動式表格
                $maxTable = !empty($tableNumbers) ? max($tableNumbers) : 9;
                $tableIndex = 0;
                $inputId = 0;
                for ($row = 0; $row < $rows; $row++) {
                    echo "<tr>";
                    for ($col = 0; $col < $colsPerRow; $col++) {
                        echo "<td>";
                        echo "<table class='inner'>";
                        // 9 列
                        for ($i = 1; $i <= 9; $i++) {
                            echo "<tr>";
                            $baseIndex = $row * $colsPerRow + $col;
                            if (isset($tableNumbers[$baseIndex])) {
                                $base = $tableNumbers[$baseIndex];
                                $result = $base * $i;
                                // 顯示題目與輸入框
                                $qid = "q{$inputId}";
                                echo "<td>";
                                echo "<span class='question' id='label-{$qid}'>{$base} × {$i} = </span>";
                                echo "<input type='text' class='answer-input' id='{$qid}' data-ans='{$result}' data-qidx='{$inputId}' autocomplete='off' size='3' disabled>";
                                echo "<span class='feedback' id='fb-{$qid}'></span>";
                                echo "</td>";
                                $inputId++;
                            } else {
                                echo "<td>&nbsp;</td>";
                            }
                            // 其餘4欄空白
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
            <?php if ($showError): ?>
                <div style="color:red;">請勿輸入文字、科學符號、運算符號、小數點或超過9的數字</div>
            <?php endif; ?>
        </section>
    </main>
    <a class="fixedBtn" href="../../../index.php">Back</a>

    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="/PHP-Exercises/assets/js/47multiplicationTable.js"></script>
</body>

</html>