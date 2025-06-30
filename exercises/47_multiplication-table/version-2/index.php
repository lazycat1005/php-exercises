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
            <h2>九九乘法表（3欄×3列的大表格，每格為5欄×9列的乘法子表格）</h2>
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

                $maxTable = !empty($tableNumbers) ? max($tableNumbers) : 9;
                $tableIndex = 0;
                for ($row = 0; $row < $rows; $row++) {
                    echo "<tr>";
                    for ($col = 0; $col < $colsPerRow; $col++) {
                        echo "<td>";
                        echo "<table class='inner'>";
                        for ($i = 1; $i <= 9; $i++) {
                            echo "<tr>";
                            $baseIndex = $row * $colsPerRow + $col;
                            if (isset($tableNumbers[$baseIndex])) {
                                $base = $tableNumbers[$baseIndex];
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
            <?php if ($showError): ?>
                <div style="color:red;">請勿輸入文字、科學符號、運算符號、小數點或超過9的數字</div>
            <?php endif; ?>
        </section>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script>
            // 前端驗證
            $('#tableForm').on('submit', function(e) {
                const input = $('#tableCount').val();
                // 僅允許數字、逗號、全形逗號、~、-、空白
                const valid = /^[0-9,，~\- ]+$/.test(input);
                if (!valid) {
                    $('#inputError').text('請勿輸入文字、科學符號、運算符號、小數點或超過9的數字');
                    e.preventDefault();
                    return;
                }
                // 檢查是否有超過9的數字
                const cleaned = input.replace(/[， ]/g, ',');
                const parts = cleaned.split(',');
                for (const part of parts) {
                    if (part.includes('~') || part.includes('-')) {
                        const range = part.split(/~|-/);
                        if (range.length === 2) {
                            const start = parseInt(range[0], 10);
                            const end = parseInt(range[1], 10);
                            if (start > 9 || end > 9) {
                                $('#inputError').text('請勿輸入超過9的數字');
                                e.preventDefault();
                                return;
                            }
                        }
                    } else if (part !== '' && !isNaN(part)) {
                        if (parseInt(part, 10) > 9) {
                            $('#inputError').text('請勿輸入超過9的數字');
                            e.preventDefault();
                            return;
                        }
                    }
                }
                $('#inputError').text('');
            });
            // 若後端有錯誤訊息，顯示於前端
            if (window.inputErrorMsg) {
                $('#inputError').text(window.inputErrorMsg);
            }
        </script>
    </main>

    <a class="fixedBtn" href="../../../index.php">Back</a>
</body>

</html>