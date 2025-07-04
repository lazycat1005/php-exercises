<?php
$newCssName = '47multiplicationTable.css'; // 添加此行
$metaKey = "multiplication-table";
include '../../../header.php';
require_once '../../../app/helper/47MultiplicationTableHelper.php';
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
                $controllerPath = '../../../app/controller/47MultiplicationTableController.php';
                if (file_exists($controllerPath)) {
                    require_once $controllerPath;
                    $controller = new MultiplicationTableController();
                    $result = $controller->generateTable($input);
                    $showError = !$result['success'];
                    $tableNumbers = $result['numbers'];
                } else {
                    // if (isset($_GET['tableCount']) && !preg_match('/^[0-9,，~\- ]+$/u', $input)) {
                    //     $showError = true;
                    //     echo "<script>window.inputErrorMsg = '請勿輸入文字、科學符號、運算符號、小數點或超過9的數字';</script>";
                    // } else {
                    //     echo "<script>window.inputErrorMsg = '';</script>";
                    // }
                    // $tableNumbers = (!$showError) ? range(1, 9) : [];
                }

                if (empty($tableNumbers) && !$showError) {
                    $tableNumbers = [9];
                }
                echo MultiplicationTableHelper::renderMultiplicationTable($tableNumbers, $colsPerRow, $rows, $tablesPerCell);
                ?>
            </table>
            <?php if ($showError): ?>
                <div style="color:red;">請勿輸入文字、科學符號、運算符號、小數點或超過9的數字</div>
            <?php endif; ?>
        </section>
        <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
        <script src="/PHP-Exercises/assets/js/47multiplicationTable.js"></script>
    </main>

    <a class="fixedBtn" href="../../../index.php">Back</a>
</body>

</html>