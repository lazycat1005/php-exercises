<?php
header('Content-Type: application/json'); // 設定回應內容為 JSON 格式

// 檢查是否為 POST 請求
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // 檢查必要參數是否存在
  if (isset($_POST['temperature'], $_POST['unit'])) {
    $temperature = floatval($_POST['temperature']); // 取得並轉換溫度值
    $unit = $_POST['unit']; // 取得單位

    switch ($unit) {
      case 'celsius':
        // 攝氏轉華氏
        $fahrenheit = round(($temperature * 9 / 5) + 32, 2);
        echo json_encode([
          'success' => true,
          'celsius' => $temperature,
          'fahrenheit' => $fahrenheit
        ]);
        break;

      case 'fahrenheit':
        // 華氏轉攝氏
        $celsius = round(($temperature - 32) * 5 / 9, 2);
        echo json_encode([
          'success' => true,
          'fahrenheit' => $temperature,
          'celsius' => $celsius
        ]);
        break;

      default:
        // 單位無效
        echo json_encode([
          'success' => false,
          'message' => '無效的單位。'
        ]);
        break;
    }
  } else {
    // 缺少必要參數
    echo json_encode([
      'success' => false,
      'message' => '缺少必要的參數。'
    ]);
  }
} else {
  // 請求方法無效
  echo json_encode([
    'success' => false,
    'message' => '無效的請求方法。'
  ]);
}
