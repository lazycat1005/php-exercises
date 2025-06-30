<?php
$metaKey = "leap-years";
$exerciseDir = __DIR__ . '/../';
include '../../../header.php';
?>

<body>
  <main id="phpVersion" class="container">
    <h1>閏年計算器</h1>

    <form action="" method="GET">
      <fieldset id="leapYearCalculation">
        <label for="year">請輸入年份:</label>
        <input type="number" id="year" name="year" min="1" max="3000" step="1" required>
        <button type="submit">計算是否為閏年</button>
      </fieldset>
    </form>

    <section class="result">
      <h2>結果:</h2>
      <?php
      //讓使用者隨意輸入一個 1~3000 間的年份，用 PHP 的原生 DateTime 計算 (不使用插件的意思)，顯示該年度"總天數"是幾天，是不是閏年
      if (isset($_GET['year'])) {
        $year = intval($_GET['year']);
        if ($year < 1 || $year > 3000) {
          echo "<p>請輸入有效的年份 (1-3000)。</p>";
        } else {
          $date = new DateTime("$year-01-01");
          $daysInYear = $date->format('L') ? 366 : 365; // 判斷是否為閏年
          $isLeapYear = $date->format('L') ? "是" : "否";
          echo "<p>年份: $year</p>";
          echo "<p>總天數: $daysInYear 天</p>";
          echo "<p>是否為閏年: $isLeapYear</p>";
        }
      }
      ?>
    </section>

    <a class="fixedBtn" href="../../../index.php">Back</a>
</body>

</html>