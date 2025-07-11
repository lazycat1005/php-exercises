<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;

HtmlHelper::renderHeader('takeAwayGame', '54takeAwayGame.css');
?>

<main>
    <header>
        <h1>取火柴遊戲</h1>
        <p>點擊火柴棒取走 1~3 根，然後按下 [換人] 讓電腦取走火柴。</p>
    </header>

    <section>
        <div id="matchsticks"></div>
        <button id="btn-next">換人</button>
        <button id="btn-restart">開始新遊戲</button>
    </section>

</main>


<?php HtmlHelper::renderFooter("54takeAwayGame.js"); ?>