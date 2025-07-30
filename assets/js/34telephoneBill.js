// 34 電話費計算 - 合併自 version-js
$(function () {
  let $billHistory = {};

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
  const validateInput = function (duration) {
    if (isNaN(duration) || duration < 0) {
      alert("請輸入有效的通話時長（正整數）");
      return false;
    }
    return true;
  };

  /**
   * 計算第一階段費用（0-600分鐘）
   * @param {number} duration 通話時長
   * @returns {object} 包含費用和計算詳情
   */
  const calculateTier1Bill = function (duration) {
    const $amount = duration * RATES.BASE_RATE;
    const $detail = `前600分鐘：${duration} × ${
      RATES.BASE_RATE
    } = ${$amount.toFixed(2)} 元`;

    return {
      part1: $amount,
      part2: 0,
      part3: 0,
      calcDetail: $detail,
    };
  };

  /**
   * 計算第二階段費用（601-1200分鐘）
   * @param {number} duration 通話時長
   * @returns {object} 包含費用和計算詳情
   */
  const calculateTier2Bill = function (duration) {
    const $part1 = RATES.TIER1_LIMIT * RATES.BASE_RATE;
    const $part2 =
      (duration - RATES.TIER1_LIMIT) * RATES.BASE_RATE * RATES.TIER2_DISCOUNT;

    const $detail =
      `前600分鐘：600 × ${RATES.BASE_RATE} = ${$part1.toFixed(2)} 元<br>` +
      `第601~${duration}分鐘：${duration - RATES.TIER1_LIMIT} × ${
        RATES.BASE_RATE
      } × ${RATES.TIER2_DISCOUNT} = ${$part2.toFixed(2)} 元<br>` +
      `總計：${($part1 + $part2).toFixed(2)} 元`;

    return {
      part1: $part1,
      part2: $part2,
      part3: 0,
      calcDetail: $detail,
    };
  };

  /**
   * 計算第三階段費用（1201分鐘以上）
   * @param {number} duration 通話時長
   * @returns {object} 包含費用和計算詳情
   */
  const calculateTier3Bill = function (duration) {
    const $part1 = RATES.TIER1_LIMIT * RATES.BASE_RATE;
    const $part2 = RATES.TIER1_LIMIT * RATES.BASE_RATE * RATES.TIER2_DISCOUNT;
    const $part3 =
      (duration - RATES.TIER2_LIMIT) * RATES.BASE_RATE * RATES.TIER3_DISCOUNT;

    const $detail =
      `前600分鐘：600 × ${RATES.BASE_RATE} = ${$part1.toFixed(2)} 元<br>` +
      `第601~1200分鐘：600 × ${RATES.BASE_RATE} × ${
        RATES.TIER2_DISCOUNT
      } = ${$part2.toFixed(2)} 元<br>` +
      `第1201~${duration}分鐘：${duration - RATES.TIER2_LIMIT} × ${
        RATES.BASE_RATE
      } × ${RATES.TIER3_DISCOUNT} = ${$part3.toFixed(2)} 元<br>` +
      `總計：${($part1 + $part2 + $part3).toFixed(2)} 元`;

    return {
      part1: $part1,
      part2: $part2,
      part3: $part3,
      calcDetail: $detail,
    };
  };

  /**
   * 加上四捨五入提示訊息
   * @param {string} calcDetail 原始計算詳情
   * @returns {string} 加上提示的計算詳情
   */
  const addRoundingMessage = function (calcDetail) {
    return (
      calcDetail +
      '<span style="color:#007bff;font-weight:bold;">計算金額四捨五入後為該月應繳金額</span>'
    );
  };

  /**
   * 計算電話費用和各階段費用
   * @param {number} duration 通話時長
   * @returns {object} 包含總費用、各階段費用和計算詳情
   */
  const calculateBill = function (duration) {
    let $billResult = {};

    if (duration <= RATES.TIER1_LIMIT) {
      $billResult = calculateTier1Bill(duration);
    } else if (duration <= RATES.TIER2_LIMIT) {
      $billResult = calculateTier2Bill(duration);
    } else {
      $billResult = calculateTier3Bill(duration);
    }

    $billResult.calcDetail = addRoundingMessage($billResult.calcDetail);

    const $totalAmount =
      $billResult.part1 + $billResult.part2 + $billResult.part3;
    const $roundedAmount = Math.round($totalAmount);

    return {
      amount: $roundedAmount,
      part1: Math.round($billResult.part1),
      part2: Math.round($billResult.part2),
      part3: Math.round($billResult.part3),
      calcDetail: $billResult.calcDetail,
    };
  };

  /**
   * 管理帳單歷史紀錄
   * @param {number} duration 通話時長
   * @param {object} billResult 計費結果
   */
  const manageBillHistory = function (duration, billResult) {
    const $timestamp = Date.now();
    $billHistory[$timestamp] = {
      duration: duration,
      amount: billResult.amount,
      part1: billResult.part1,
      part2: billResult.part2,
      part3: billResult.part3,
    };

    limitHistoryRecords();
  };

  /**
   * 限制歷史紀錄數量，只保留最新 12 筆
   */
  const limitHistoryRecords = function () {
    const $keys = Object.keys($billHistory);
    if ($keys.length > 12) {
      delete $billHistory[$keys[0]];
    }
  };

  /**
   * 更新計費紀錄
   * @param {number} duration 通話時長
   * @param {object} billResult 計費結果
   */
  const updateBillHistory = function (duration, billResult) {
    manageBillHistory(duration, billResult);
  };

  /**
   * 建立計算詳情顯示元素
   * @param {string} calcDetail 計算詳情
   */
  const createCalcDetailElement = function (calcDetail) {
    if ($("section .calc-detail").length === 0) {
      $("section h3").after(
        '<div class="calc-detail" style="margin:4px 0 10px 0;color:#555;"></div>'
      );
    }
    $("section .calc-detail").html(calcDetail);
  };

  /**
   * 顯示計算結果
   * @param {object} billResult 計費結果
   */
  const displayResult = function (billResult) {
    $("section h3 span").text(` ${billResult.amount} 元`);
    $("section.result").show();
    createCalcDetailElement(billResult.calcDetail);
  };

  /**
   * 產生單筆歷史紀錄詳情文字
   * @param {object} item 帳單項目
   * @returns {string} 詳情文字
   */
  const generateHistoryItemDetail = function (item) {
    let $detail = `通話時長: ${item.duration} 分鐘, 電話費: ${item.amount} 元`;
    if (item.part1 > 0) $detail += `，600分鐘內: ${item.part1} 元`;
    if (item.part2 > 0) $detail += `，601~1200分鐘: ${item.part2} 元`;
    if (item.part3 > 0) $detail += `，1201分鐘以上: ${item.part3} 元`;
    return $detail;
  };

  /**
   * 建立歷史紀錄列表
   * @returns {jQuery} 歷史紀錄列表元素
   */
  const createHistoryList = function () {
    const $historyList = $("<ol></ol>");

    Object.values($billHistory).forEach(function (item) {
      const $detail = generateHistoryItemDetail(item);
      const $listItem = $("<li></li>").text($detail);
      $historyList.append($listItem);
    });

    return $historyList;
  };

  /**
   * 顯示歷史紀錄
   */
  const displayHistory = function () {
    const $historyList = createHistoryList();
    $("section h4").html($historyList);
  };

  /**
   * 計算總金額和帳單數量
   * @returns {object} 包含總金額和數量的物件
   */
  const calculateSummaryData = function () {
    const $total = Object.values($billHistory).reduce(function (sum, item) {
      return sum + item.amount;
    }, 0);
    const $roundedTotal = Math.round($total);
    const $historyCount = Object.keys($billHistory).length;

    return {
      total: $roundedTotal,
      count: $historyCount,
    };
  };

  /**
   * 顯示總計摘要
   */
  const displaySummary = function () {
    const $summaryData = calculateSummaryData();
    const $summary = `<div>共 ${$summaryData.count} 期帳單，金額一共是: ${$summaryData.total} 元</div>`;
    $("section h3").html($summary);
  };

  /**
   * 處理表單提交邏輯
   * @param {number} callDuration 通話時長
   */
  const handleFormSubmission = function (callDuration) {
    // 驗證輸入
    if (!validateInput(callDuration)) {
      return;
    }

    // 計算費用
    const $billResult = calculateBill(callDuration);

    // 更新紀錄
    updateBillHistory(callDuration, $billResult);

    // 顯示結果
    displayResult($billResult);
    displayHistory();
    displaySummary();

    // 清空輸入欄位
    $("#callDuration").val("");
  };

  /**
   * 初始化表單事件
   */
  const initializeFormEvents = function () {
    $("form").on("submit", function (e) {
      e.preventDefault();
      const $callDuration = parseFloat($("#callDuration").val());
      handleFormSubmission($callDuration);
    });
  };

  // 初始化
  initializeFormEvents();
});
