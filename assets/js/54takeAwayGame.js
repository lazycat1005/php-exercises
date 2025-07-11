$(function () {
  function renderMatchsticks(count = 12) {
    const $container = $("#matchsticks");
    $container.empty();
    for (let i = 0; i < count; i++) {
      $container.append(`<div class="matchstick" data-index="${i}"></div>`);
    }
  }

  let selectedThisTurn = 0;

  // 點擊火柴動畫，限制每回最多3根
  $("#matchsticks").on("click", ".matchstick", function () {
    if (selectedThisTurn >= 3) {
      alert("每回合最多只能取 3 根火柴！");
      return;
    }
    const $stick = $(this);
    if ($stick.hasClass("removed") || $stick.hasClass("selected")) return;
    $stick.addClass("selected");
    selectedThisTurn++;
    setTimeout(() => {
      $stick.addClass("removed");
      // 判斷玩家是否取走最後一根
      if ($(".matchstick:not(.removed)").length === 0) {
        setTimeout(() => {
          alert("你輸了！");
        }, 200);
      }
    }, 120);
  });

  // 換人時重置回合計數，並讓電腦取火柴
  $("#btn-next").on("click", function () {
    if (selectedThisTurn === 0) {
      alert("請先取走 1~3 根火柴再換人！");
      return;
    }
    selectedThisTurn = 0;
    $(".matchstick.selected").removeClass("selected");

    // 電腦回合
    const $remain = $(".matchstick:not(.removed)");
    const remainCount = $remain.length;
    let take = 1;
    if (remainCount <= 4 && remainCount >= 2) {
      take = remainCount - 1; // 讓場上剩1根
    } else if (remainCount > 4) {
      take = Math.floor(Math.random() * 3) + 1;
    }
    // 電腦取火柴動畫
    for (let i = 0, taken = 0; i < $remain.length && taken < take; i++) {
      const $stick = $remain.eq(i);
      $stick.addClass("selected");
      setTimeout(() => {
        $stick.addClass("removed");
        // 判斷電腦是否取走最後一根
        if ($(".matchstick:not(.removed)").length === 0) {
          setTimeout(() => {
            alert("你贏了！");
          }, 200);
        }
      }, 120 + taken * 80);
      taken++;
    }
  });

  // 開始新遊戲
  $("#btn-restart").on("click", function () {
    renderMatchsticks(12);
    selectedThisTurn = 0;
  });

  // 頁面載入時初始化
  renderMatchsticks(12);
});
