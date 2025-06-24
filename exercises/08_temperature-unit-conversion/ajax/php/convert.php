<?php
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_POST['temperature'], $_POST['unit'])) {
    $temperature = floatval($_POST['temperature']);
    $unit = $_POST['unit'];

    switch ($unit) {
      case 'celsius':
        $fahrenheit = round(($temperature * 9 / 5) + 32, 2);
        echo json_encode([
          'success' => true,
          'celsius' => $temperature,
          'fahrenheit' => $fahrenheit
        ]);
        break;

      case 'fahrenheit':
        $celsius = round(($temperature - 32) * 5 / 9, 2);
        echo json_encode([
          'success' => true,
          'fahrenheit' => $temperature,
          'celsius' => $celsius
        ]);
        break;

      default:
        echo json_encode([
          'success' => false,
          'message' => '無效的單位。'
        ]);
        break;
    }
  } else {
    echo json_encode([
      'success' => false,
      'message' => '缺少必要的參數。'
    ]);
  }
} else {
  echo json_encode([
    'success' => false,
    'message' => '無效的請求方法。'
  ]);
}
