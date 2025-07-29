$(function () {
  // 遊戲狀態管理
  let selectedThisTurn = 0;
  const MAX_STICKS_PER_TURN = 3;
  const INITIAL_STICK_COUNT = 12;

  // 渲染火柴棍
  // count: 火柴棍數量，預設為 12 根
  function renderMatchsticks(count = INITIAL_STICK_COUNT) {
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

  // 驗證火柴棍選擇的邏輯
  function validateStickSelection() {
    if (selectedThisTurn >= MAX_STICKS_PER_TURN) {
      showAlert("每回合最多只能取 3 根火柴！");
      return false;
    }
    return true;
  }

  // 檢查遊戲結束狀態
  function checkGameEnd() {
    if (getRemainingSticksCount() === 0) {
      setTimeout(() => {
        showAlert("你輸了！");
      }, 200);
    }
  }

  // 顯示提示訊息
  function showAlert(message) {
    alert(message);
  }

  // 處理玩家點擊火柴棍的事件
  // $stick: jQuery 對象，表示被點擊的火柴棍元素
  function handlePlayerStickClick($stick) {
    if (!validateStickSelection()) {
      return;
    }

    if (!isStickSelectable($stick)) {
      return;
    }

    selectStick($stick);
  }

  // 選擇火柴棍的動畫效果
  function selectStick($stick) {
    $stick.addClass("selected");
    selectedThisTurn++;

    setTimeout(() => {
      $stick.addClass("removed");
      checkGameEnd();
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

  // 計算電腦應該取走的火柴數量
  function calculateComputerTakeCount(remainCount) {
    if (remainCount <= 4 && remainCount >= 2) {
      return remainCount - 1;
    } else if (remainCount > 4) {
      return Math.floor(Math.random() * MAX_STICKS_PER_TURN) + 1;
    }
    return 1;
  }

  // 檢查電腦勝利狀態
  function checkComputerWin() {
    if (getRemainingSticksCount() === 0) {
      setTimeout(() => {
        showAlert("你贏了！");
      }, 200);
    }
  }

  // 電腦選擇火柴棍的動畫效果
  function computerSelectSticks($remainingSticks, takeCount) {
    for (
      let i = 0, taken = 0;
      i < $remainingSticks.length && taken < takeCount;
      i++
    ) {
      const $stick = $remainingSticks.eq(i);
      $stick.addClass("selected");

      setTimeout(() => {
        $stick.addClass("removed");
        checkComputerWin();
      }, 120 + taken * 80);

      taken++;
    }
  }

  // 電腦取火柴棍的邏輯
  // 根據剩餘火柴棍的數量決定取走的數量
  // 如果剩餘火柴棍數量在 2 到 4 之間，則取走剩餘數量 - 1 根
  // 如果剩餘火柴棍數量大於 4，則隨機取走 1 到 3 根
  // 如果剩餘火柴棍數量為 1，則直接取
  function computerTakeSticks() {
    const $remainingSticks = getRemainingSticks();
    const remainCount = $remainingSticks.length;
    const takeCount = calculateComputerTakeCount(remainCount);

    computerSelectSticks($remainingSticks, takeCount);
  }

  // 重置本回合的選擇
  // 清除選中的火柴棍，重置選擇數量
  function resetTurn() {
    selectedThisTurn = 0;
    $(".matchstick.selected").removeClass("selected");
  }

  // 驗證玩家回合是否有效
  function validatePlayerTurn() {
    if (selectedThisTurn === 0) {
      showAlert("請先取走 1~3 根火柴再換人！");
      return false;
    }
    return true;
  }

  // 處理下一回合的邏輯
  // 如果玩家沒有選擇火柴棍，則提示玩家先取走
  function handleNextTurn() {
    if (!validatePlayerTurn()) {
      return;
    }

    resetTurn();
    computerTakeSticks();
  }

  // 重置遊戲
  // 重新渲染火柴棍，重置選擇數量
  function handleRestart() {
    renderMatchsticks(INITIAL_STICK_COUNT);
    selectedThisTurn = 0;
  }

  // 初始化事件綁定
  function initializeEventHandlers() {
    $("#matchsticks").on("click", ".matchstick", function () {
      handlePlayerStickClick($(this));
    });

    $("#btn-next").on("click", function () {
      handleNextTurn();
    });

    $("#btn-restart").on("click", function () {
      handleRestart();
    });
  }

  // 初始化遊戲
  function initializeGame() {
    renderMatchsticks(INITIAL_STICK_COUNT);
    initializeEventHandlers();
  }

  // 頁面載入時初始化
  initializeGame();
});
