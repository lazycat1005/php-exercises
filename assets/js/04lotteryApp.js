// 防抖函數，避免短時間內重複觸發
function debounce(fn, delay) {
  let timer = null;
  return function (...args) {
    if (timer) {
      clearTimeout(timer);
    }
    timer = setTimeout(() => {
      fn.apply(this, args);
    }, delay);
  };
}

$(function () {
  // 防止連續送出表單
  let lastSubmitTime = 0;
  $("#lotteryForm").on("submit", function (e) {
    const now = Date.now();
    if (now - lastSubmitTime < 1000) {
      // 1秒內禁止連續送出
      e.preventDefault();
      alert("請勿重複送出，請稍候再試！");
      return false;
    }
    lastSubmitTime = now;
  });

  // 點擊重選按鈕，清空所有選號
  $("#resetNumbers").on("click", function () {
    $('input[type="checkbox"][name="numbers[]"]').prop("checked", false);
  });

  // 點擊電腦選號，隨機選出6個號碼
  $("#autoPick").on("click", function () {
    const total = 42;
    const pickCount = 6;
    // 產生 1~42 的陣列
    const pool = Array.from(
      {
        length: total,
      },
      (_, i) => i + 1
    );
    // 洗牌
    for (let i = pool.length - 1; i > 0; i--) {
      const j = Math.floor(Math.random() * (i + 1));
      [pool[i], pool[j]] = [pool[j], pool[i]];
    }
    const selected = pool.slice(0, pickCount);
    // 先清空
    $('input[type="checkbox"][name="numbers[]"]').prop("checked", false);
    // 勾選隨機選中的號碼
    selected.forEach((num) => {
      $('input[type="checkbox"][name="numbers[]"][value="' + num + '"]').prop(
        "checked",
        true
      );
    });
  });

  // 限制最多只能選6個號碼
  $('input[type="checkbox"][name="numbers[]"]').on("change", function () {
    const checkedCount = $(
      'input[type="checkbox"][name="numbers[]"]:checked'
    ).length;
    if (checkedCount > 6) {
      alert("最多只能選擇 6 個號碼！");
      $(this).prop("checked", false);
    }
  });

  // 若有 PHP alertMsg，彈窗顯示
  if (window.alertMsg && window.alertMsg.length > 0) {
    alert(window.alertMsg);
  }

  // 開獎動畫：每個號碼延遲0.5秒依序顯示
  const $mainNums = $(".lotto-main");
  const $specialNum = $(".lotto-special");
  if ($mainNums.length > 0) {
    $mainNums.each(function (i) {
      setTimeout(() => {
        $(this).fadeIn(150);
      }, 500 * i);
    });
    setTimeout(() => {
      $specialNum.fadeIn(200);
      // 動畫結束後執行兌獎
      doPrizeCheck();
    }, 500 * $mainNums.length);
  }

  // 兌獎邏輯：比對每一注與開獎號碼，顯示中獎結果
  function doPrizeCheck() {
    // 取得開獎主號碼
    const mainNumbers = [];
    $(".lotto-main").each(function () {
      mainNumbers.push(Number($(this).text()));
    });
    // 取得特別號
    const specialNumber = Number($(".lotto-special").text());

    // 逐筆比對每注
    $(".records-section ol li").each(function () {
      // 取得本注號碼
      const numbersText = $(this).find("strong").text();
      const numbers = numbersText.split(",").map((s) => Number(s.trim()));
      let matchMain = 0;
      let matchSpecial = false;
      numbers.forEach((num) => {
        if (mainNumbers.includes(num)) matchMain++;
        if (num === specialNumber) matchSpecial = true;
      });

      // 判斷獎項
      let prize = "未中獎";
      if (matchMain === 6) {
        prize = "頭獎";
      } else if (matchMain === 5 && matchSpecial) {
        prize = "貳獎";
      } else if (matchMain === 5) {
        prize = "參獎";
      } else if (matchMain === 4 && matchSpecial) {
        prize = "肆獎";
      } else if (matchMain === 4) {
        prize = "伍獎 ($2,000)";
      } else if (matchMain === 3 && matchSpecial) {
        prize = "陸獎 ($1,000)";
      } else if (matchMain === 2 && matchSpecial) {
        prize = "柒獎 ($400)";
      } else if (matchMain === 3) {
        prize = "普獎 ($400)";
      }
      // 若已經有獎項標籤則先移除
      $(this).find(".prize-label").remove();
      // 顯示獎項
      $(this).append(
        `<span class="prize-label" style="margin-left:1rem;color:#d2691e;font-weight:bold;">${prize}</span>`
      );
    });
  }
});
