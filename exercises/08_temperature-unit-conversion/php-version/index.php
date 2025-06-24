<!DOCTYPE html>
<html lang="zh-TW">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="index,follow">
  <meta name="googlebot" content="index,follow">
  <link rel="icon" sizes="192x192" href="#">
  <title>溫度單位轉換</title>
  <meta name="description" content="溫度單位轉換">
  <link rel="stylesheet" href="./css/main.css">
</head>

<body>
  <div class="container">
    <h1>溫度單位轉換</h1>

    <form action="" method="post">
      <fieldset id="temperatureConversion">
        <div class="celsius">
          <label for="celsius">攝氏溫度 (°C):</label>
          <input type="number" name="celsius" step="any" value="<?= isset($_POST['celsius']) ? htmlspecialchars($_POST['celsius']) : '' ?>">
        </div>

        <div class="buttons">
          <button type="submit" name="convert" value="toCelsius">← 轉換成攝氏</button>
          <button type="submit" name="convert" value="toFahrenheit">轉換成華氏 →</button>

        </div>

        <div class="fahrenheit">
          <label for="fahrenheit">華氏溫度 (°F):</label>
          <input type="number" name="fahrenheit" step="any" value="<?= isset($_POST['fahrenheit']) ? htmlspecialchars($_POST['fahrenheit']) : '' ?>">
        </div>
      </fieldset>
    </form>

    <div class="messageText">
      <?php
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $convert = $_POST['convert'] ?? null;
        $celsius = $_POST['celsius'] ?? '';
        $fahrenheit = $_POST['fahrenheit'] ?? '';

        $hasCelsius = $celsius !== '';
        $hasFahrenheit = $fahrenheit !== '';

        if ($hasCelsius && $hasFahrenheit) {
          echo "<p>請只填一個欄位，不能兩個都填。</p>";
        } elseif (!$hasCelsius && !$hasFahrenheit) {
          echo "<p>請輸入一個溫度值。</p>";
        } else {
          if ($convert === 'toFahrenheit') {
            if (!$hasCelsius) {
              echo "<p>請輸入攝氏溫度來進行轉換。</p>";
            } elseif (!is_numeric($celsius)) {
              echo "<p>攝氏溫度無效，請輸入數字。</p>";
            } else {
              $c = floatval($celsius);
              $f = round(($c * 9 / 5) + 32, 2);
              echo "<p>攝氏 {$c}°C 等於華氏 {$f}°F</p>";
            }
          } elseif ($convert === 'toCelsius') {
            if (!$hasFahrenheit) {
              echo "<p>請輸入華氏溫度來進行轉換。</p>";
            } elseif (!is_numeric($fahrenheit)) {
              echo "<p>華氏溫度無效，請輸入數字。</p>";
            } else {
              $f = floatval($fahrenheit);
              $c = round(($f - 32) * 5 / 9, 2);
              echo "<p>華氏 {$f}°F 等於攝氏 {$c}°C</p>";
            }
          } else {
            echo "<p>請選擇轉換方向。</p>";
          }
        }
      }
      ?>
    </div>
  </div>


</body>

</html>