<?php
// 設定必要的變數
$metaKey = "temperature";
$exerciseDir = __DIR__;

// 引入共同的頁首
require_once '../../../header.php';

// 引入驗證器
require_once '../utils/Validator.php';

// 處理表單提交
$validator = new Validator();
$errors = [];
$fahrenheit = '';
$celsius = '';
$convertType = '';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && (isset($_GET['fahrenheit']) || isset($_GET['celsius']))) {
    if (isset($_GET['fahrenheit']) && $_GET['fahrenheit'] !== '') {
        $fahrenheit = $_GET['fahrenheit'];
        $convertType = 'f_to_c';

        $error = $validator->validateTemperature($fahrenheit, '華氏');
        if ($error) {
            $errors['fahrenheit'] = $error;
        } else {
            // 華氏轉攝氏：C = (F - 32) × 5/9
            $celsius = round(($fahrenheit - 32) * 5 / 9, 2);
        }
    } elseif (isset($_GET['celsius']) && $_GET['celsius'] !== '') {
        $celsius = $_GET['celsius'];
        $convertType = 'c_to_f';

        $error = $validator->validateTemperature($celsius, '攝氏');
        if ($error) {
            $errors['celsius'] = $error;
        } else {
            // 攝氏轉華氏：F = C × 9/5 + 32
            $fahrenheit = round($celsius * 9 / 5 + 32, 2);
        }
    }
}
?>

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="text-center mb-5">
                    <h1 class="display-4 fw-bold text-primary">
                        <i class="bi bi-thermometer-half me-3"></i>
                        溫度單位轉換器
                    </h1>
                    <p class="lead text-muted">在華氏溫度和攝氏溫度之間進行精確轉換</p>
                </div>

                <?php if (!empty($errors)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong>輸入錯誤：</strong>
                        <ul class="mb-0 mt-2">
                            <?php foreach ($errors as $error): ?>
                                <li><?= htmlspecialchars($error) ?></li>
                            <?php endforeach; ?>
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (empty($errors) && ($fahrenheit !== '' || $celsius !== '')): ?>
                    <div class="result-display">
                        <h3 class="mb-3">
                            <i class="bi bi-check-circle-fill me-2"></i>
                            轉換結果
                        </h3>
                        <?php if ($convertType === 'f_to_c'): ?>
                            <div class="row align-items-center">
                                <div class="col-5 text-end">
                                    <span class="fs-2 fw-bold"><?= htmlspecialchars($fahrenheit) ?>°F</span>
                                </div>
                                <div class="col-2 text-center">
                                    <i class="bi bi-arrow-right fs-1"></i>
                                </div>
                                <div class="col-5 text-start">
                                    <span class="fs-2 fw-bold"><?= htmlspecialchars($celsius) ?>°C</span>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="row align-items-center">
                                <div class="col-5 text-end">
                                    <span class="fs-2 fw-bold"><?= htmlspecialchars($celsius) ?>°C</span>
                                </div>
                                <div class="col-2 text-center">
                                    <i class="bi bi-arrow-right fs-1"></i>
                                </div>
                                <div class="col-5 text-start">
                                    <span class="fs-2 fw-bold"><?= htmlspecialchars($fahrenheit) ?>°F</span>
                                </div>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="row g-4">
                    <!-- 華氏溫度輸入 -->
                    <div class="col-md-6">
                        <div class="card temperature-card h-100 border-0 shadow">
                            <div class="card-header bg-gradient-primary text-white text-center">
                                <h4 class="mb-0">
                                    <i class="bi bi-thermometer-snow icon-fahrenheit me-2"></i>
                                    華氏溫度 (°F)
                                </h4>
                            </div>
                            <div class="card-body p-4">
                                <form method="GET" action="" id="fahrenheitForm">
                                    <div class="mb-3">
                                        <label for="fahrenheit" class="form-label fw-semibold">
                                            輸入華氏溫度值
                                        </label>
                                        <div class="input-group">
                                            <input
                                                type="text"
                                                class="form-control form-control-lg <?= isset($errors['fahrenheit']) ? 'is-invalid' : '' ?>"
                                                id="fahrenheit"
                                                name="fahrenheit"
                                                value="<?= htmlspecialchars($fahrenheit) ?>"
                                                placeholder="例如：32"
                                                autocomplete="off">
                                            <span class="input-group-text">°F</span>
                                            <?php if (isset($errors['fahrenheit'])): ?>
                                                <div class="invalid-feedback">
                                                    <?= htmlspecialchars($errors['fahrenheit']) ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-convert w-100">
                                        <i class="bi bi-arrow-repeat me-2"></i>
                                        轉換為攝氏溫度
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- 攝氏溫度輸入 -->
                    <div class="col-md-6">
                        <div class="card temperature-card h-100 border-0 shadow">
                            <div class="card-header bg-gradient-primary text-white text-center">
                                <h4 class="mb-0">
                                    <i class="bi bi-thermometer-sun icon-celsius me-2"></i>
                                    攝氏溫度 (°C)
                                </h4>
                            </div>
                            <div class="card-body p-4">
                                <form method="GET" action="" id="celsiusForm">
                                    <div class="mb-3">
                                        <label for="celsius" class="form-label fw-semibold">
                                            輸入攝氏溫度值
                                        </label>
                                        <div class="input-group">
                                            <input
                                                type="text"
                                                class="form-control form-control-lg <?= isset($errors['celsius']) ? 'is-invalid' : '' ?>"
                                                id="celsius"
                                                name="celsius"
                                                value="<?= htmlspecialchars($celsius) ?>"
                                                placeholder="例如：0"
                                                autocomplete="off">
                                            <span class="input-group-text">°C</span>
                                            <?php if (isset($errors['celsius'])): ?>
                                                <div class="invalid-feedback">
                                                    <?= htmlspecialchars($errors['celsius']) ?>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-convert w-100">
                                        <i class="bi bi-arrow-repeat me-2"></i>
                                        轉換為華氏溫度
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 轉換公式說明 -->
                <div class="card mt-4 border-0 shadow">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="bi bi-calculator me-2"></i>
                            轉換公式
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h6 class="text-primary">華氏轉攝氏</h6>
                                <p class="mb-0"><code>°C = (°F - 32) × 5/9</code></p>
                            </div>
                            <div class="col-md-6">
                                <h6 class="text-danger">攝氏轉華氏</h6>
                                <p class="mb-0"><code>°F = °C × 9/5 + 32</code></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 常見溫度參考 -->
                <div class="card mt-4 border-0 shadow">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">
                            <i class="bi bi-bookmark-star me-2"></i>
                            常見溫度參考
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3 text-center">
                                <div class="p-3 bg-primary bg-opacity-10 rounded">
                                    <strong>水的冰點</strong><br>
                                    0°C = 32°F
                                </div>
                            </div>
                            <div class="col-md-3 text-center">
                                <div class="p-3 bg-info bg-opacity-10 rounded">
                                    <strong>室溫</strong><br>
                                    20°C = 68°F
                                </div>
                            </div>
                            <div class="col-md-3 text-center">
                                <div class="p-3 bg-warning bg-opacity-10 rounded">
                                    <strong>人體體溫</strong><br>
                                    37°C = 98.6°F
                                </div>
                            </div>
                            <div class="col-md-3 text-center">
                                <div class="p-3 bg-danger bg-opacity-10 rounded">
                                    <strong>水的沸點</strong><br>
                                    100°C = 212°F
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <a class="fixedBtn" href="../../../index.php">Back</a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>
    <script src="./js/app.js"></script>
</body>

</html>