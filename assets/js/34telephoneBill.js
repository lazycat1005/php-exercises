// 34 電話費計算 - 合併自 version-js
$(function () {
  let billHistory = {};

  // 電話費計算費率常數
  const RATES = {
    BASE_RATE: 0.5,
    TIER2_DISCOUNT: 0.9,
    TIER3_DISCOUNT: 0.79,
    TIER1_LIMIT: 600,
    TIER2_LIMIT: 1200,
  };

  /**
   * 驗證輸入的通話時長
   * @param {number} duration 通話時長
   * @returns {boolean} 是否有效
   */
  const validateInput = (duration) => {
    if (isNaN(duration) || duration < 0) {
      alert("請輸入有效的通話時長（正整數）");
      return false;
    }
    return true;
  };

  /**
   * 計算電話費用和各階段費用
   * @param {number} duration 通話時長
   * @returns {object} 包含總費用、各階段費用和計算詳情
   */
  const calculateBill = (duration) => {
    let part1 = 0,
      part2 = 0,
      part3 = 0;
    let calcDetail = "";

    if (duration <= RATES.TIER1_LIMIT) {
      // 第一階段：0-600分鐘
      part1 = duration * RATES.BASE_RATE;
      calcDetail = `前600分鐘：${duration} × ${
        RATES.BASE_RATE
      } = ${part1.toFixed(2)} 元`;
    } else if (duration <= RATES.TIER2_LIMIT) {
      // 第二階段：601-1200分鐘
      part1 = RATES.TIER1_LIMIT * RATES.BASE_RATE;
      part2 =
        (duration - RATES.TIER1_LIMIT) * RATES.BASE_RATE * RATES.TIER2_DISCOUNT;
      calcDetail =
        `前600分鐘：600 × ${RATES.BASE_RATE} = ${part1.toFixed(2)} 元<br>` +
        `第601~${duration}分鐘：${duration - RATES.TIER1_LIMIT} × ${
          RATES.BASE_RATE
        } × ${RATES.TIER2_DISCOUNT} = ${part2.toFixed(2)} 元<br>` +
        `總計：${(part1 + part2).toFixed(2)} 元`;
    } else {
      // 第三階段：1201分鐘以上
      part1 = RATES.TIER1_LIMIT * RATES.BASE_RATE;
      part2 = RATES.TIER1_LIMIT * RATES.BASE_RATE * RATES.TIER2_DISCOUNT;
      part3 =
        (duration - RATES.TIER2_LIMIT) * RATES.BASE_RATE * RATES.TIER3_DISCOUNT;
      calcDetail =
        `前600分鐘：600 × ${RATES.BASE_RATE} = ${part1.toFixed(2)} 元<br>` +
        `第601~1200分鐘：600 × ${RATES.BASE_RATE} × ${
          RATES.TIER2_DISCOUNT
        } = ${part2.toFixed(2)} 元<br>` +
        `第1201~${duration}分鐘：${duration - RATES.TIER2_LIMIT} × ${
          RATES.BASE_RATE
        } × ${RATES.TIER3_DISCOUNT} = ${part3.toFixed(2)} 元<br>` +
        `總計：${(part1 + part2 + part3).toFixed(2)} 元`;
    }

    calcDetail +=
      '<br><span style="color:#007bff;font-weight:bold;">計算金額四捨五入後為該月應繳金額</span>';

    const totalAmount = part1 + part2 + part3;
    const roundedAmount = Math.round(totalAmount);

    return {
      amount: roundedAmount,
      part1: Math.round(part1),
      part2: Math.round(part2),
      part3: Math.round(part3),
      calcDetail: calcDetail,
    };
  };

  /**
   * 更新計費紀錄
   * @param {number} duration 通話時長
   * @param {object} billResult 計費結果
   */
  const updateBillHistory = (duration, billResult) => {
    const timestamp = Date.now();
    billHistory[timestamp] = {
      duration: duration,
      amount: billResult.amount,
      part1: billResult.part1,
      part2: billResult.part2,
      part3: billResult.part3,
    };

    // 只保留最新 12 筆紀錄
    const keys = Object.keys(billHistory);
    if (keys.length > 12) {
      delete billHistory[keys[0]];
    }
  };

  /**
   * 顯示計算結果
   * @param {object} billResult 計費結果
   */
  const displayResult = (billResult) => {
    $("section h3 span").text(` ${billResult.amount} 元`);
    $("section.result").show();

    // 顯示計算過程
    if ($("section .calc-detail").length === 0) {
      $("section h3").after(
        '<div class="calc-detail" style="margin:4px 0 10px 0;color:#555;"></div>'
      );
    }
    $("section .calc-detail").html(billResult.calcDetail);
  };

  /**
   * 顯示歷史紀錄
   */
  const displayHistory = () => {
    const $historyList = $("<ol></ol>");

    Object.values(billHistory).forEach((item) => {
      let detail = `通話時長: ${item.duration} 分鐘, 電話費: ${item.amount} 元`;
      if (item.part1 > 0) detail += `，600分鐘內: ${item.part1} 元`;
      if (item.part2 > 0) detail += `，601~1200分鐘: ${item.part2} 元`;
      if (item.part3 > 0) detail += `，1201分鐘以上: ${item.part3} 元`;

      const $listItem = $("<li></li>").text(detail);
      $historyList.append($listItem);
    });

    $("section h4").html($historyList);
  };

  /**
   * 顯示總計摘要
   */
  const displaySummary = () => {
    const total = Object.values(billHistory).reduce(
      (sum, item) => sum + item.amount,
      0
    );
    const roundedTotal = Math.round(total);
    const historyCount = Object.keys(billHistory).length;

    const summary = `<div>共 ${historyCount} 期帳單，金額一共是: ${roundedTotal} 元</div>`;
    $("section h3").html(summary);
  };

  // 表單提交事件處理
  $("form").on("submit", (e) => {
    e.preventDefault();

    const callDuration = parseFloat($("#callDuration").val());

    // 驗證輸入
    if (!validateInput(callDuration)) {
      return;
    }

    // 計算費用
    const billResult = calculateBill(callDuration);

    // 更新紀錄
    updateBillHistory(callDuration, billResult);

    // 顯示結果
    displayResult(billResult);
    displayHistory();
    displaySummary();

    // 清空輸入欄位
    $("#callDuration").val("");
  });
});
