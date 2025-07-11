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
    <link rel="stylesheet" href="./assets/css/all.css">
</head>

<body>
    <main id="indexPage" class="container">
        <h1>PHP 練習題</h1>

        <section class="exercisesCards">
            <?php
            // 讀取 PHP 陣列設定檔
            $exercises = require __DIR__ . '/app/config/exercises.php';

            // 顯示所有題目
            foreach ($exercises as $exercise) {
                echo '<div class="exercisesCard">';
                echo '<h2>' . htmlspecialchars($exercise['title']) . '</h2>';
                echo '<ul>';
                foreach ($exercise['links'] as $type => $url) {
                    $typeName = $type;
                    echo '<li><a href="' . htmlspecialchars($url) . '">' . htmlspecialchars($exercise['title']) . "($typeName)</a></li>";
                }
                echo '</ul>';
                echo '</div>';
            }
            ?>
        </section>
    </main>
</body>

</html>