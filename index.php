<!DOCTYPE html>
<html lang="zh-TW">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="index,follow">
  <meta name="googlebot" content="index,follow">
  <link rel="icon" sizes="192x192" href="#">
  <title>PHP 練習題</title>
  <meta name="description" content="PHP 練習題">
  <link rel="stylesheet" href="./css/main.css">
</head>

<body>
  <div class="container">
    <h1>PHP 練習題</h1>

    <div class="exercisesCards">
      <?php
      //將所有的題目與版本、連結、標題名稱製作成一個多維陣列
      $exercises = [
        [
          'title' => '溫度轉換',
          'links' => [
            'ajax' => './exercises/08_temperature-unit-conversion/ajax/',
            'php' => './exercises/08_temperature-unit-conversion/php-version/'
          ]
        ],
        [
          'title' => '電話帳單',
          'links' => [
            'php' => './exercises/47_telephone-bill-calculation/php-version/',
            'js' => './exercises/47_telephone-bill-calculation/js-version/'
          ]
        ]
      ];

      // 顯示所有題目
      foreach ($exercises as $exercise) {
        echo '<div class="exercisesCard">';
        echo '<h2>' . htmlspecialchars($exercise['title']) . '</h2>';
        echo '<ul>';
        foreach ($exercise['links'] as $type => $url) {
          $typeName = '';
          if ($type === 'ajax') $typeName = 'Ajax';
          elseif ($type === 'php') $typeName = 'PHP';
          elseif ($type === 'js') $typeName = 'JS';
          else $typeName = ucfirst($type);
          echo '<li><a href="' . htmlspecialchars($url) . '">' . htmlspecialchars($exercise['title']) . "($typeName)</a></li>";
        }
        echo '</ul>';
        echo '</div>';
      }
      ?>
    </div>
  </div>
</body>

</html>