/**
 * 防止表單重複提交
 */
function preventFormResubmission() {
  let $lastSubmitTime = 0;
  $("#lotteryForm").on("submit", function (e) {
    const $now = Date.now();
    if ($now - $lastSubmitTime < 1000) {
      e.preventDefault();
      alert("請勿重複送出，請稍候再試！");
      return false;
    }
    $lastSubmitTime = $now;
  });
}

/**
 * 清空所有選號
 */
function resetAllNumbers() {
  $("#resetNumbers").on("click", function () {
    $('input[type="checkbox"][name="numbers[]"]').prop("checked", false);
  });
}

/**
 * 產生指定範圍的隨機號碼
 * @param {number} total 總號碼數量
 * @param {number} pickCount 要選擇的號碼數量
 * @returns {Array} 隨機選中的號碼陣列
 */
function generateRandomNumbers(total, pickCount) {
  const $pool = Array.from({ length: total }, (_, i) => i + 1);

  // 洗牌演算法
  for (let i = $pool.length - 1; i > 0; i--) {
    const $randomIndex = Math.floor(Math.random() * (i + 1));
    [$pool[i], $pool[$randomIndex]] = [$pool[$randomIndex], $pool[i]];
  }

  return $pool.slice(0, pickCount);
}

/**
 * 電腦自動選號功能
 */
function setupAutoPick() {
  $("#autoPick").on("click", function () {
    const $total = 42;
    const $pickCount = 6;
    const $selectedNumbers = generateRandomNumbers($total, $pickCount);

    // 先清空所有選號
    $('input[type="checkbox"][name="numbers[]"]').prop("checked", false);

    // 勾選隨機選中的號碼
    $selectedNumbers.forEach(function (num) {
      $('input[type="checkbox"][name="numbers[]"][value="' + num + '"]').prop(
        "checked",
        true
      );
    });
  });
}

/**
 * 限制選號數量
 */
function limitNumberSelection() {
  $('input[type="checkbox"][name="numbers[]"]').on("change", function () {
    const $checkedCount = $(
      'input[type="checkbox"][name="numbers[]"]:checked'
    ).length;
    if ($checkedCount > 6) {
      alert("最多只能選擇 6 個號碼！");
      $(this).prop("checked", false);
    }
  });
}

/**
 * 顯示 PHP 傳遞的警告訊息
 */
function showAlertMessage() {
  if (window.alertMsg && window.alertMsg.length > 0) {
    alert(window.alertMsg);
  }
}

/**
 * 取得開獎號碼
 * @returns {Object} 包含主號碼陣列和特別號的物件
 */
function getDrawNumbers() {
  const $mainNumbers = [];
  $(".lotto-main").each(function () {
    $mainNumbers.push(Number($(this).text()));
  });
  const $specialNumber = Number($(".lotto-special").text());

  return {
    mainNumbers: $mainNumbers,
    specialNumber: $specialNumber,
  };
}

/**
 * 判斷中獎獎項
 * @param {number} matchMain 符合主號碼數量
 * @param {boolean} matchSpecial 是否符合特別號
 * @returns {string} 獎項名稱
 */
function determinePrize(matchMain, matchSpecial) {
  if (matchMain === 6) {
    return "頭獎";
  } else if (matchMain === 5 && matchSpecial) {
    return "貳獎";
  } else if (matchMain === 5) {
    return "參獎";
  } else if (matchMain === 4 && matchSpecial) {
    return "肆獎";
  } else if (matchMain === 4) {
    return "伍獎 ($2,000)";
  } else if (matchMain === 3 && matchSpecial) {
    return "陸獎 ($1,000)";
  } else if (matchMain === 2 && matchSpecial) {
    return "柒獎 ($400)";
  } else if (matchMain === 3) {
    return "普獎 ($400)";
  }
  return "未中獎";
}

/**
 * 兌獎邏輯：比對每一注與開獎號碼，顯示中獎結果
 */
function doPrizeCheck() {
  const $drawNumbers = getDrawNumbers();

  $(".records-section ol li").each(function () {
    const $numbersText = $(this).find("strong").text();
    const $userNumbers = $numbersText.split(",").map(function (s) {
      return Number(s.trim());
    });

    let $matchMain = 0;
    let $matchSpecial = false;

    $userNumbers.forEach(function (num) {
      if ($drawNumbers.mainNumbers.includes(num)) {
        $matchMain++;
      }
      if (num === $drawNumbers.specialNumber) {
        $matchSpecial = true;
      }
    });

    const $prize = determinePrize($matchMain, $matchSpecial);

    // 若已經有獎項標籤則先移除
    $(this).find(".prize-label").remove();

    // 顯示獎項
    $(this).append(
      `<span class="prize-label" style="margin-left:10px;color:#d2691e;font-weight:bold;">${$prize}</span>`
    );
  });
}

/**
 * 開獎動畫效果
 */
function playDrawAnimation() {
  const $mainNums = $(".lotto-main");
  const $specialNum = $(".lotto-special");

  if ($mainNums.length > 0) {
    $mainNums.each(function (i) {
      setTimeout(function () {
        $($mainNums[i]).fadeIn(150);
      }, 500 * i);
    });

    setTimeout(function () {
      $specialNum.fadeIn(200);
      // 動畫結束後執行兌獎
      doPrizeCheck();
    }, 500 * $mainNums.length);
  }
}

/**
 * 初始化所有功能
 */
function initializeLotteryApp() {
  preventFormResubmission();
  resetAllNumbers();
  setupAutoPick();
  limitNumberSelection();
  showAlertMessage();
  playDrawAnimation();
}

$(function () {
  initializeLotteryApp();
});
