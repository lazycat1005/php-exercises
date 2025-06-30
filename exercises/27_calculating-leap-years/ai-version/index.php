<?php
$metaKey = "leap-years";
$exerciseDir = dirname(__FILE__) . '/..';

// 處理表單提交
$year = null;
$totalDays = null;
$isLeapYear = null;
$errors = [];
$success = false;

// 輸入驗證函數
function validateYear($input)
{
    $errors = [];

    // 檢查是否為空
    if (empty(trim($input))) {
        $errors[] = "請輸入年份";
        return $errors;
    }

    // 檢查是否為數字
    if (!is_numeric($input)) {
        $errors[] = "年份必須是數字";
        return $errors;
    }

    $year = (int)$input;

    // 檢查範圍
    if ($year < 1 || $year > 3000) {
        $errors[] = "年份必須介於 1 到 3000 之間";
        return $errors;
    }

    return $errors;
}

// 使用 PHP DateTime 計算年份資訊
function calculateYearInfo($year)
{
    try {
        // 建立該年的 1 月 1 日
        $startOfYear = new DateTime("$year-01-01");

        // 建立下一年的 1 月 1 日
        $startOfNextYear = new DateTime(($year + 1) . "-01-01");

        // 計算天數差
        $interval = $startOfYear->diff($startOfNextYear);
        $totalDays = $interval->days;

        // 判斷是否為閏年（總天數為366天）
        $isLeapYear = ($totalDays == 366);

        return [
            'totalDays' => $totalDays,
            'isLeapYear' => $isLeapYear
        ];
    } catch (Exception $e) {
        return false;
    }
}

// 處理 GET 請求
if ($_SERVER['REQUEST_METHOD'] === 'GET' && !empty($_GET['year'])) {
    $year = trim($_GET['year']);
    $errors = validateYear($year);

    if (empty($errors)) {
        $yearInfo = calculateYearInfo((int)$year);

        if ($yearInfo !== false) {
            $totalDays = $yearInfo['totalDays'];
            $isLeapYear = $yearInfo['isLeapYear'];
            $success = true;
        } else {
            $errors[] = "計算年份資訊時發生錯誤";
        }
    }
}

include_once '../../../header.php';
?>

<!-- Bootstrap 5 CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

<body>
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-8">
                <div class="card shadow-lg border-0 mt-4">
                    <div class="card-header bg-primary text-white text-center">
                        <h1 class="mb-0">
                            <i class="fas fa-calendar-alt me-2"></i>
                            閏年計算器
                        </h1>
                        <p class="mb-0 mt-2">使用 PHP DateTime 原生函數計算年份資訊</p>
                    </div>

                    <div class="card-body p-4">
                        <!-- 功能說明 -->
                        <div class="alert alert-info mb-4">
                            <h5><i class="fas fa-info-circle me-2"></i>功能說明</h5>
                            <ul class="mb-0">
                                <li>輸入 1 到 3000 之間的年份</li>
                                <li>使用 PHP DateTime 原生函數計算該年度總天數</li>
                                <li>自動判斷是否為閏年</li>
                                <li>具備前後端驗證機制</li>
                            </ul>
                        </div>

                        <!-- 錯誤訊息 -->
                        <?php if (!empty($errors)): ?>
                            <div class="alert alert-danger" role="alert">
                                <h6><i class="fas fa-exclamation-triangle me-2"></i>輸入錯誤：</h6>
                                <ul class="mb-0">
                                    <?php foreach ($errors as $error): ?>
                                        <li><?= htmlspecialchars($error) ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        <?php endif; ?>

                        <!-- 成功結果 -->
                        <?php if ($success): ?>
                            <div class="alert alert-success" role="alert">
                                <h5><i class="fas fa-check-circle me-2"></i>計算結果</h5>
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>年份：</strong><?= htmlspecialchars($year) ?> 年
                                    </div>
                                    <div class="col-md-6">
                                        <strong>總天數：</strong><?= htmlspecialchars($totalDays) ?> 天
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <span class="badge <?= $isLeapYear ? 'bg-success' : 'bg-secondary' ?> fs-6">
                                        <?= $isLeapYear ? '✓ 是閏年' : '✗ 不是閏年' ?>
                                    </span>
                                </div>
                            </div>
                        <?php endif; ?>

                        <!-- 輸入表單 -->
                        <form method="GET" action="" class="needs-validation" novalidate>
                            <div class="row align-items-end">
                                <div class="col-md-8">
                                    <label for="year" class="form-label">
                                        <i class="fas fa-calendar me-2"></i>請輸入年份 (1-3000)
                                    </label>
                                    <input
                                        type="number"
                                        class="form-control form-control-lg"
                                        id="year"
                                        name="year"
                                        min="1"
                                        max="3000"
                                        value="<?= htmlspecialchars($year ?? '') ?>"
                                        placeholder="例如：2024"
                                        required>
                                    <div class="invalid-feedback">
                                        請輸入 1 到 3000 之間的有效年份
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <button type="submit" class="btn btn-primary btn-lg w-100">
                                        <i class="fas fa-calculator me-2"></i>計算
                                    </button>
                                </div>
                            </div>
                        </form>

                        <!-- 閏年規則說明 -->
                        <div class="mt-4">
                            <h6><i class="fas fa-question-circle me-2"></i>閏年判斷規則：</h6>
                            <div class="small text-muted">
                                <ul>
                                    <li>能被 4 整除且不能被 100 整除的年份是閏年</li>
                                    <li>能被 400 整除的年份是閏年</li>
                                    <li>閏年有 366 天，平年有 365 天</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a class="fixedBtn" href="../../../index.php">Back</a>

    <!-- jQuery 1.12.4 -->
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <!-- Bootstrap 5 JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- 前端驗證 jQuery 版本 -->
    <script>
        $(document).ready(function() {
            'use strict';

            // 驗證函數
            function validateYearInput($yearInput) {
                const year = parseInt($yearInput.val());
                let isValid = true;
                let errorMessage = '';

                if (!$yearInput.val().trim()) {
                    isValid = false;
                    errorMessage = '請輸入年份';
                } else if (isNaN(year)) {
                    isValid = false;
                    errorMessage = '年份必須是數字';
                } else if (year < 1 || year > 3000) {
                    isValid = false;
                    errorMessage = '年份必須介於 1 到 3000 之間';
                }

                return {
                    isValid: isValid,
                    errorMessage: errorMessage
                };
            }

            // 設定驗證狀態
            function setValidationState($input, isValid, errorMessage) {
                if (!isValid) {
                    $input[0].setCustomValidity(errorMessage);
                    $input.addClass('is-invalid').removeClass('is-valid');

                    // 更新錯誤訊息
                    const $feedback = $input.next('.invalid-feedback');
                    if ($feedback.length) {
                        $feedback.text(errorMessage);
                    }
                } else {
                    $input[0].setCustomValidity('');
                    $input.removeClass('is-invalid').addClass('is-valid');
                }
            }

            // 表單提交驗證
            $('.needs-validation').on('submit', function(event) {
                const $form = $(this);
                const $yearInput = $form.find('#year');
                const validation = validateYearInput($yearInput);

                if (!validation.isValid) {
                    event.preventDefault();
                    event.stopPropagation();
                    setValidationState($yearInput, false, validation.errorMessage);
                } else {
                    setValidationState($yearInput, true, '');
                }

                if (!this.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                $form.addClass('was-validated');
            });

            // 即時驗證
            $('#year').on('input', function() {
                const $yearInput = $(this);
                const validation = validateYearInput($yearInput);

                if ($yearInput.val().trim()) {
                    if (!validation.isValid) {
                        setValidationState($yearInput, false, validation.errorMessage);
                    } else {
                        setValidationState($yearInput, true, '');
                    }
                } else {
                    // 清空時移除所有驗證狀態
                    $yearInput[0].setCustomValidity('');
                    $yearInput.removeClass('is-invalid is-valid');
                }
            });

            // 增強 UX：輸入框獲得焦點時的效果
            $('#year').on('focus', function() {
                $(this).closest('.col-md-8').find('label').addClass('text-primary');
            }).on('blur', function() {
                $(this).closest('.col-md-8').find('label').removeClass('text-primary');
            });

            // 增強 UX：提交按鈕 hover 效果
            $('.btn-primary').on('mouseenter', function() {
                $(this).addClass('shadow-lg');
            }).on('mouseleave', function() {
                $(this).removeClass('shadow-lg');
            });

            // 增強 UX：表單提交時的載入狀態
            $('.needs-validation').on('submit', function() {
                const $submitBtn = $(this).find('button[type="submit"]');
                const originalText = $submitBtn.html();

                $submitBtn.prop('disabled', true)
                    .html('<i class="fas fa-spinner fa-spin me-2"></i>計算中...');

                // 模擬載入時間（實際應用中會在表單驗證通過後執行）
                setTimeout(function() {
                    $submitBtn.prop('disabled', false).html(originalText);
                }, 100);
            });
        });
    </script>
</body>

</html>