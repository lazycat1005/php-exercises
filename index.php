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
      // 讀取 JSON 檔案
      $json = file_get_contents(__DIR__ . '/exercises.json');
      $exercises = json_decode($json, true);

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