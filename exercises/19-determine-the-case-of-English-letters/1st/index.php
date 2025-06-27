<?php
$metaKey = "English-letters";
$exerciseDir = __DIR__ . '/../';
include '../../../header.php';
?>


<body>
  <!-- 提供一個輸入框可輸入一串字，利用 PHP 把它們都切割出來成一個字元，並顯示它對應的 ASCII code ，且標註是英文大寫 or 英文小寫 or 半形符號 or 其他字元(分辨不出是前三類的就是其他字元) -->
  <div class="container">
    <h1>判斷英文字母的大小寫</h1>
    <form id="charForm" action="" method="GET">
      <fieldset>
        <label for="charInput">請輸入字元:</label>
        <input type="text" id="charInput" name="charInput" maxlength="1" required>
        <button type="submit">判斷</button>
      </fieldset>
    </form>

    <div id="result">
      <?php
      if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $char = $_GET['charInput'];

        if (strlen($char) !== 1) {
          echo "<p>請輸入單一字元。</p>";
        } else {
          $singleChar = mb_substr($char, 0, 1, "UTF-8");
          $ascii = ord($singleChar);
          if ($ascii >= 65 && $ascii <= 90) {
            echo "<p>字元: " . htmlspecialchars($singleChar) . "，ASCII碼: $ascii" . "類型: 大寫英文字母</p>";
          } elseif ($ascii >= 97 && $ascii <= 122) {
            echo "<p>字元: " . htmlspecialchars($singleChar) . "，ASCII碼: $ascii" . "類型: 小寫英文字母</p>";
          } elseif ($ascii >= 48 && $ascii <= 57) {
            echo "<p>字元: " . htmlspecialchars($singleChar) . "，ASCII碼: $ascii" . "類型: 數字</p>";
          } else {
            echo "<p>字元: " . htmlspecialchars($singleChar) . "，ASCII碼: $ascii" . "類型: 其他字元</p>";
          }
        }
      }
      ?>
    </div>
  </div>

  <a class="fixedBtn" href="../../../index.php">Back</a>
</body>

</html>