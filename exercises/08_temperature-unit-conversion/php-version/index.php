<?php
$metaKey = "temperature";
$exerciseDir = __DIR__ . '/../';  // 對應 08_temperature-unit-conversion/
include '../../../header.php';
?>

<body>
  <div id="phpVersion" class="container">
    <h1>溫度單位轉換</h1>

    <form action="" method="post">
      <fieldset id="temperatureConversion">
        <div class="celsius">
          <label for="celsius">攝氏溫度 (°C):</label>
          <input type="number" name="celsius" step="any">
        </div>

        <div class="buttons">
          <button type="submit" name="convert" value="toCelsius">← 轉換成攝氏</button>
          <button type="button" id="clearBtn">清除</button>
          <button type="submit" name="convert" value="toFahrenheit">轉換成華氏 →</button>
        </div>

        <div class="fahrenheit">
          <label for="fahrenheit">華氏溫度 (°F):</label>
          <input type="number" name="fahrenheit" step="any">
        </div>
      </fieldset>
    </form>

    <div class="messageText">
      <?php
      function validateTemperature($value, $label)
      {
        $trimmed = trim($value);
        $isEmpty = $trimmed === '';
        $isInvalid = preg_match('/e/i', $trimmed);
        $isNumeric = is_numeric($trimmed);

        if ($isEmpty) {
          return "請輸入{$label}溫度來進行轉換。";
        } elseif ($isInvalid) {
          return "無效的值（不能包含科學記號）。";
        } elseif (!$isNumeric) {
          return "{$label}溫度無效，請輸入數字。";
        }
        return ''; // 表示驗證通過
      }

      // 檢查是否為 POST 請求
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $convert = $_POST['convert'] ?? null;
        $celsius = $_POST['celsius'] ?? '';
        $fahrenheit = $_POST['fahrenheit'] ?? '';

        $hasCelsius = $celsius !== '';
        $hasFahrenheit = $fahrenheit !== '';

        // 同時輸入兩個欄位
        if ($hasCelsius && $hasFahrenheit) {
          echo "<p>請只填一個欄位，不能兩個都填。</p>";
        }
        // 兩個欄位都沒填
        elseif (!$hasCelsius && !$hasFahrenheit) {
          echo "<p>請輸入一個溫度值。</p>";
        } else {
          // 攝氏轉華氏
          if ($convert === 'toFahrenheit') {
            $msg = validateTemperature($celsius, '攝氏');
            if ($msg !== '') {
              echo "<p>{$msg}</p>";
            } else {
              $c = floatval($celsius);
              $f = round(($c * 9 / 5) + 32, 2);
              echo "<p>攝氏 {$c}°C 等於華氏 {$f}°F</p>";
            }
          }
          // 華氏轉攝氏
          elseif ($convert === 'toCelsius') {
            $msg = validateTemperature($fahrenheit, '華氏');
            if ($msg !== '') {
              echo "<p>{$msg}</p>";
            } else {
              $f = floatval($fahrenheit);
              $c = round(($f - 32) * 5 / 9, 2);
              echo "<p>華氏 {$f}°F 等於攝氏 {$c}°C</p>";
            }
          }
          // 未選擇轉換方向
          else {
            echo "<p>請選擇轉換方向。</p>";
          }
        }
      }
      ?>
    </div>
  </div>

  <a class="fixedBtn" href="../../../index.php">Back</a>

  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const celsiusInput = document.querySelector('input[name="celsius"]');
      const fahrenheitInput = document.querySelector('input[name="fahrenheit"]');
      const toCelsiusBtn = document.querySelector('button[value="toCelsius"]');
      const toFahrenheitBtn = document.querySelector('button[value="toFahrenheit"]');

      // 綁定 keydown 事件
      [celsiusInput, fahrenheitInput].forEach(input => {
        input.addEventListener('keydown', function(e) {
          if (e.key === 'Enter') {
            e.preventDefault(); // 阻止預設送出行為

            // 根據哪個欄位有值來決定按哪個按鈕
            if (this.name === 'celsius' && this.value.trim() !== '') {
              toFahrenheitBtn.click();
            } else if (this.name === 'fahrenheit' && this.value.trim() !== '') {
              toCelsiusBtn.click();
            }
          }
        });
      });

      // 清除事件
      const clearBtn = document.getElementById('clearBtn');
      const messageBox = document.querySelector('.messageText');

      clearBtn.addEventListener('click', () => {
        celsiusInput.value = '';
        fahrenheitInput.value = '';
        messageBox.innerHTML = '';
      });
    });
  </script>
</body>

</html>