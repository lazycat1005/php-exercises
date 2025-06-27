<?php
$metaKey = "English-letters";
$exerciseDir = __DIR__ . '/../';
include '../../../header.php';
?>

<body>
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
        // 驗證，如果不是大寫字母，返回警告
        if (!preg_match('/^[A-Z]$/', $char)) {
          echo "<p>請輸入大寫英文字母 (A-Z)。</p>";
        }

        if (strlen($char) !== 1) {
          echo "<p>請輸入單一字元。</p>";
        } else {
          $singleChar = mb_substr($char, 0, 1, "UTF-8");
          $ascii = ord($singleChar);
          if ($ascii >= 65 && $ascii <= 90) {
            echo "<p>字元: " . htmlspecialchars($singleChar) . "，ASCII碼: $ascii" . "類型: 大寫英文字母</p>";
          }
        }
      }
      ?>
    </div>
  </div>

  <a class="fixedBtn" href="../../../index.php">Back</a>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.12.4/jquery.min.js"
    integrity="sha512-jGsMH83oKe9asCpkOVkBnUrDDTp8wl+adkB2D+//JtlxO4SrLoJdhbOysIFQJloQFD+C4Fl1rMsQZF76JjV0eQ=="
    crossorigin="anonymous" referrerpolicy="no-referrer"></script>

  <script>
    // 提供一個輸入框，僅可輸入大寫英文字母，利用 JQuery 判斷，"按鍵當下"不是大寫英文，就不給輸入，使用者貼上也不行
    $(document).ready(function() {
      $('#charInput').on('keypress', function(e) {
        const charCode = e.which || e.keyCode;
        // 檢查是否為大寫英文字母
        if (!(charCode >= 65 && charCode <= 90)) {
          e.preventDefault(); // 阻止輸入
          alert('請輸入大寫英文字母 (A-Z)');
        }
      });

      // 禁止貼上非大寫英文字母
      $('#charInput').on('paste', function(e) {
        e.preventDefault(); // 阻止貼上
        alert('請輸入大寫英文字母 (A-Z)');
      });

      //禁止從歷史下拉視窗中選擇非大寫字母
      $('#charInput').on('input', function() {
        const value = $(this).val();
        // 檢查是否包含非大寫英文字母
        if (/[^A-Z]/.test(value)) {
          $(this).val(value.replace(/[^A-Z]/g, '')); // 移除非大寫字母
          alert('請輸入大寫英文字母 (A-Z)');
        }
      });
    });
  </script>
</body>

</html>