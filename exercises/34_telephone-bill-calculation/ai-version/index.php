<?php
$metaKey = "telephone";
$exerciseDir = __DIR__ . '/..';
require_once '../../../header.php';

// 新增 Bootstrap 5 和 Font Awesome 到 head
echo '<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">';
echo '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">';
echo '<link rel="stylesheet" href="./styles.css">';


// 電話費計算函數
function calculatePhoneBill($minutes)
{
    if ($minutes <= 600) {
        return $minutes * 0.5;
    } elseif ($minutes <= 1200) {
        return $minutes * 0.5 * 0.9; // 9折
    } else {
        return $minutes * 0.5 * 0.79; // 79折
    }
}

// 驗證輸入
function validateMinutes($input)
{
    $trimmed = trim($input);

    if ($trimmed === '') {
        return ['isValid' => false, 'error' => '請輸入使用時間（分鐘）'];
    }

    if (!is_numeric($trimmed)) {
        return ['isValid' => false, 'error' => '請輸入有效的數字'];
    }

    $minutes = floatval($trimmed);

    if ($minutes < 0) {
        return ['isValid' => false, 'error' => '使用時間不能為負數'];
    }

    if ($minutes > 999999) {
        return ['isValid' => false, 'error' => '使用時間過大，請輸入合理的數值'];
    }

    return ['isValid' => true, 'value' => $minutes];
}

// 處理表單提交
$result = null;
$error = '';
$inputMinutes = '';

if (isset($_GET['minutes']) && isset($_GET['action'])) {
    $inputMinutes = $_GET['minutes'];
    $validation = validateMinutes($inputMinutes);

    if ($validation['isValid']) {
        $minutes = $validation['value'];
        $bill = calculatePhoneBill($minutes);
        $result = [
            'minutes' => $minutes,
            'bill' => $bill,
            'formattedBill' => number_format($bill, 2)
        ];
    } else {
        $error = $validation['error'];
    }
}
?>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8 col-xl-6">
                <div class="card shadow-lg">
                    <div class="card-header bg-primary text-white">
                        <h1 class="card-title mb-0 text-center">
                            <i class="fas fa-phone-alt me-2"></i>電話費計算器
                        </h1>
                    </div>
                    <div class="card-body p-4">
                        <!-- 計費規則說明 -->
                        <div class="alert alert-info mb-4">
                            <h5 class="alert-heading">
                                <i class="fas fa-info-circle me-2"></i>計費規則
                            </h5>
                            <ul class="mb-0">
                                <li><strong>600 分鐘以下：</strong>每分鐘 0.5 元</li>
                                <li><strong>600~1200 分鐘：</strong>電話費以 9 折計算</li>
                                <li><strong>1200 分鐘以上：</strong>電話費以 79 折計算</li>
                            </ul>
                        </div>

                        <!-- 計算方式選擇 -->
                        <div class="mb-4">
                            <h5 class="mb-3">選擇計算方式：</h5>
                            <div class="btn-group w-100" role="group">
                                <input type="radio" class="btn-check" name="calculationMode" id="phpMode" value="php" checked>
                                <label class="btn btn-outline-primary" for="phpMode">
                                    <i class="fab fa-php me-1"></i>PHP 計算（轉頁）
                                </label>

                                <input type="radio" class="btn-check" name="calculationMode" id="jsMode" value="js">
                                <label class="btn btn-outline-success" for="jsMode">
                                    <i class="fab fa-js-square me-1"></i>JavaScript 計算（即時）
                                </label>
                            </div>
                        </div>

                        <!-- PHP 計算表單 -->
                        <div id="phpForm">
                            <form method="GET" action="">
                                <div class="mb-3">
                                    <label for="minutes" class="form-label">使用時間（分鐘）</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="far fa-clock"></i>
                                        </span>
                                        <input type="text"
                                            class="form-control <?= $error ? 'is-invalid' : ($result ? 'is-valid' : '') ?>"
                                            id="minutes"
                                            name="minutes"
                                            value="<?= htmlspecialchars($inputMinutes) ?>"
                                            placeholder="請輸入使用時間（例如：300）"
                                            required>
                                        <?php if ($error): ?>
                                            <div class="invalid-feedback">
                                                <?= htmlspecialchars($error) ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <button type="submit" name="action" value="calculate" class="btn btn-primary w-100">
                                    <i class="fas fa-calculator me-2"></i>計算電話費
                                </button>
                            </form>
                        </div>

                        <!-- JavaScript 計算表單 -->
                        <div id="jsForm" style="display: none;">
                            <div class="mb-3">
                                <label for="jsMinutes" class="form-label">使用時間（分鐘）</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <i class="far fa-clock"></i>
                                    </span>
                                    <input type="text"
                                        class="form-control"
                                        id="jsMinutes"
                                        placeholder="請輸入使用時間（例如：300）">
                                    <div class="invalid-feedback" id="jsError"></div>
                                </div>
                            </div>
                            <button type="button" id="jsCalculate" class="btn btn-success w-100">
                                <i class="fas fa-calculator me-2"></i>即時計算電話費
                            </button>
                        </div>

                        <!-- PHP 計算結果 -->
                        <?php if ($result): ?>
                            <div class="alert alert-success mt-4">
                                <h5 class="alert-heading">
                                    <i class="fas fa-check-circle me-2"></i>計算結果
                                </h5>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <strong>使用時間：</strong><?= number_format($result['minutes'], 2) ?> 分鐘
                                    </div>
                                    <div class="col-sm-6">
                                        <strong>電話費：</strong>NT$ <?= $result['formattedBill'] ?> 元
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- JavaScript 計算結果區域 -->
                        <div id="jsResults" class="mt-4" style="display: none;">
                            <h5>計算歷史記錄</h5>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>序號</th>
                                            <th>使用時間（分鐘）</th>
                                            <th>電話費（元）</th>
                                            <th>計算時間</th>
                                        </tr>
                                    </thead>
                                    <tbody id="resultTableBody">
                                    </tbody>
                                </table>
                            </div>
                            <button type="button" id="clearHistory" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-trash me-1"></i>清除記錄
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // 計算電話費的 JavaScript 函數
        function calculatePhoneBill(minutes) {
            if (minutes <= 600) {
                return minutes * 0.5;
            } else if (minutes <= 1200) {
                return minutes * 0.5 * 0.9; // 9折
            } else {
                return minutes * 0.5 * 0.79; // 79折
            }
        }

        // 驗證輸入的 JavaScript 函數
        function validateMinutes(input) {
            const trimmed = input.trim();

            if (trimmed === '') {
                return {
                    isValid: false,
                    error: '請輸入使用時間（分鐘）'
                };
            }

            if (!/^-?\d*\.?\d+$/.test(trimmed)) {
                return {
                    isValid: false,
                    error: '請輸入有效的數字'
                };
            }

            const minutes = parseFloat(trimmed);

            if (isNaN(minutes)) {
                return {
                    isValid: false,
                    error: '請輸入有效的數字'
                };
            }

            if (minutes < 0) {
                return {
                    isValid: false,
                    error: '使用時間不能為負數'
                };
            }

            if (minutes > 999999) {
                return {
                    isValid: false,
                    error: '使用時間過大，請輸入合理的數值'
                };
            }

            return {
                isValid: true,
                value: minutes
            };
        }

        // 計算記錄陣列
        let calculationHistory = [];
        let historyCounter = 0;

        // DOM 元素
        const phpForm = document.getElementById('phpForm');
        const jsForm = document.getElementById('jsForm');
        const jsResults = document.getElementById('jsResults');
        const jsMinutesInput = document.getElementById('jsMinutes');
        const jsCalculateBtn = document.getElementById('jsCalculate');
        const jsError = document.getElementById('jsError');
        const resultTableBody = document.getElementById('resultTableBody');
        const clearHistoryBtn = document.getElementById('clearHistory');

        // 模式切換事件
        document.querySelectorAll('input[name="calculationMode"]').forEach(radio => {
            radio.addEventListener('change', function() {
                if (this.value === 'php') {
                    phpForm.style.display = 'block';
                    jsForm.style.display = 'none';
                    jsResults.style.display = 'none';
                } else {
                    phpForm.style.display = 'none';
                    jsForm.style.display = 'block';
                    if (calculationHistory.length > 0) {
                        jsResults.style.display = 'block';
                    }
                }
            });
        });

        // JavaScript 計算按鈕事件
        jsCalculateBtn.addEventListener('click', function() {
            const input = jsMinutesInput.value;
            const validation = validateMinutes(input);

            // 清除之前的驗證狀態
            jsMinutesInput.classList.remove('is-valid', 'is-invalid');
            jsError.textContent = '';

            if (!validation.isValid) {
                jsMinutesInput.classList.add('is-invalid');
                jsError.textContent = validation.error;
                // 添加震動效果
                jsMinutesInput.style.animation = 'shake 0.5s ease-in-out';
                setTimeout(() => {
                    jsMinutesInput.style.animation = '';
                }, 500);
                return;
            }

            // 驗證通過
            jsMinutesInput.classList.add('is-valid');

            // 添加載入效果
            const originalText = jsCalculateBtn.innerHTML;
            jsCalculateBtn.innerHTML = '<span class="loading"></span> 計算中...';
            jsCalculateBtn.disabled = true;

            // 模擬計算時間（增加使用者體驗）
            setTimeout(() => {
                const minutes = validation.value;
                const bill = calculatePhoneBill(minutes);

                // 添加到歷史記錄
                historyCounter++;
                const record = {
                    id: historyCounter,
                    minutes: minutes,
                    bill: bill,
                    timestamp: new Date().toLocaleString('zh-TW')
                };

                calculationHistory.unshift(record); // 新記錄添加到最前面

                // 更新表格
                updateResultTable();

                // 顯示結果區域
                jsResults.style.display = 'block';

                // 清空輸入框
                jsMinutesInput.value = '';
                jsMinutesInput.classList.remove('is-valid');

                // 恢復按鈕
                jsCalculateBtn.innerHTML = originalText;
                jsCalculateBtn.disabled = false;

                // 滾動到結果區域
                jsResults.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            }, 800);
        });

        // 更新結果表格
        function updateResultTable() {
            resultTableBody.innerHTML = '';

            calculationHistory.forEach((record, index) => {
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${record.id}</td>
                    <td>${record.minutes.toFixed(2)}</td>
                    <td>NT$ ${record.bill.toFixed(2)}</td>
                    <td>${record.timestamp}</td>
                `;

                // 為新記錄添加動畫效果
                if (index === 0) {
                    row.style.background = 'linear-gradient(135deg, rgba(25, 135, 84, 0.2) 0%, rgba(25, 135, 84, 0.1) 100%)';
                    row.style.animation = 'fadeInUp 0.6s ease-out';

                    // 3秒後移除高亮效果
                    setTimeout(() => {
                        row.style.background = '';
                        row.style.animation = '';
                    }, 3000);
                }

                resultTableBody.appendChild(row);
            });
        }

        // 清除歷史記錄
        clearHistoryBtn.addEventListener('click', function() {
            if (calculationHistory.length === 0) {
                return;
            }

            // 使用 Bootstrap 模態框進行確認
            if (confirm('確定要清除所有計算記錄嗎？此操作無法撤銷。')) {
                // 添加淡出動畫
                jsResults.style.transition = 'opacity 0.3s ease-out';
                jsResults.style.opacity = '0';

                setTimeout(() => {
                    calculationHistory = [];
                    historyCounter = 0;
                    jsResults.style.display = 'none';
                    jsResults.style.opacity = '1';
                }, 300);
            }
        });

        // Enter 鍵支援
        jsMinutesInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                jsCalculateBtn.click();
            }
        });
    </script>
</body>

</html>