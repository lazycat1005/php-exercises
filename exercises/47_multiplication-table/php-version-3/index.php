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

        // 互動小遊戲邏輯
        $(function() {
            const $inputs = $('.answer-input');
            if ($inputs.length > 0) {
                $inputs.eq(0).prop('disabled', false).focus();
            }

            $inputs.on('keydown', function(e) {
                // 只允許數字與 Enter
                if (
                    !(e.key >= '0' && e.key <= '9') &&
                    e.key !== 'Backspace' &&
                    e.key !== 'Tab' &&
                    e.key !== 'Enter' &&
                    e.key !== 'ArrowLeft' &&
                    e.key !== 'ArrowRight'
                ) {
                    e.preventDefault();
                }
            });

            $inputs.on('input', function() {
                // 移除非數字
                this.value = this.value.replace(/[^0-9]/g, '');
            });

            $inputs.on('keyup', function(e) {
                if (e.key !== 'Enter') return;
                const $this = $(this);
                const ans = $this.data('ans').toString();
                const val = $this.val();
                const idx = parseInt($this.data('qidx'), 10);
                const $label = $('#label-' + $this.attr('id'));
                const $fb = $('#fb-' + $this.attr('id'));

                if (val === ans) {
                    $label.css('color', 'green');
                    $fb.text('✔').css('color', 'green');
                    $this.prop('disabled', true);
                    // 啟用下一題
                    const $next = $inputs.eq(idx + 1);
                    if ($next.length) {
                        $next.prop('disabled', false).focus();
                    }
                } else {
                    $label.css('color', 'red');
                    $fb.text('✘').css('color', 'red');
                }
            });

            // 若有題目被重設，移除顏色
            $inputs.on('focus', function() {
                const $label = $('#label-' + $(this).attr('id'));
                const $fb = $('#fb-' + $(this).attr('id'));
                $label.css('color', '');
                $fb.text('');
            });
        });
    </script>
</body>

</html>