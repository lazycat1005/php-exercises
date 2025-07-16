$(function () {
  // 初始化選擇的火柴數量
  // 每回合最多只能取 3 根火柴
  let selectedThisTurn = 0;

  // 渲染火柴棍
  // count: 火柴棍數量，預設為 12 根
  function renderMatchsticks(count = 12) {
    const $container = $("#matchsticks");
    $container.empty();
    for (let i = 0; i < count; i++) {
      $container.append(`<div class="matchstick" data-index="${i}"></div>`);
    }
  }

  // 檢查火柴棍是否可被選擇
  // $stick: jQuery 對象，表示火柴棍元素
  function isStickSelectable($stick) {
    return !$stick.hasClass("removed") && !$stick.hasClass("selected");
  }

  // 處理玩家點擊火柴棍的事件
  // $stick: jQuery 對象，表示被點擊的火柴棍元素
  function handlePlayerStickClick($stick) {
    if (selectedThisTurn >= 3) {
      alert("每回合最多只能取 3 根火柴！");
      return;
    }
    if (!isStickSelectable($stick)) return;
    $stick.addClass("selected");
    selectedThisTurn++;
    setTimeout(() => {
      $stick.addClass("removed");
      if (getRemainingSticksCount() === 0) {
        setTimeout(() => {
          alert("你輸了！");
        }, 200);
      }
    }, 120);
  }

  // 獲取剩餘的火柴棍
  // 返回 jQuery 對象，包含所有未被移除的火柴
  function getRemainingSticks() {
    return $(".matchstick:not(.removed)");
  }

  // 獲取剩餘火柴棍的數量
  // 返回剩餘火柴棍的數量
  function getRemainingSticksCount() {
    return getRemainingSticks().length;
  }

  // 電腦取火柴棍的邏輯
  // 根據剩餘火柴棍的數量決定取走的數量
  // 如果剩餘火柴棍數量在 2 到 4 之間，則取走剩餘數量 - 1 根
  // 如果剩餘火柴棍數量大於 4，則隨機取走 1 到 3 根
  // 如果剩餘火柴棍數量為 1，則直接取
  function computerTakeSticks() {
    const $remain = getRemainingSticks();
    const remainCount = $remain.length;
    let take = 1;
    if (remainCount <= 4 && remainCount >= 2) {
      take = remainCount - 1;
    } else if (remainCount > 4) {
      take = Math.floor(Math.random() * 3) + 1;
    }
    for (let i = 0, taken = 0; i < $remain.length && taken < take; i++) {
      const $stick = $remain.eq(i);
      $stick.addClass("selected");
      setTimeout(() => {
        $stick.addClass("removed");
        if (getRemainingSticksCount() === 0) {
          setTimeout(() => {
            alert("你贏了！");
          }, 200);
        }
      }, 120 + taken * 80);
      taken++;
    }
  }

  // 重置本回合的選擇
  // 清除選中的火柴棍，重置選擇數量
  function resetTurn() {
    selectedThisTurn = 0;
    $(".matchstick.selected").removeClass("selected");
  }

  // 處理下一回合的邏輯
  // 如果玩家沒有選擇火柴棍，則提示玩家先取走
  function handleNextTurn() {
    if (selectedThisTurn === 0) {
      alert("請先取走 1~3 根火柴再換人！");
      return;
    }
    resetTurn();
    computerTakeSticks();
  }

  // 重置遊戲
  // 重新渲染火柴棍，重置選擇數量
  function handleRestart() {
    renderMatchsticks(12);
    selectedThisTurn = 0;
  }

  // 事件綁定
  $("#matchsticks").on("click", ".matchstick", function () {
    handlePlayerStickClick($(this));
  });

  $("#btn-next").on("click", function () {
    handleNextTurn();
  });

  $("#btn-restart").on("click", function () {
    handleRestart();
  });

  // 頁面載入時初始化
  renderMatchsticks(12);
});
