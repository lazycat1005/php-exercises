// 34 電話費計算 - 合併自 version-js
$(function () {
  let billHistory = {};

  $("form").on("submit", function (event) {
    event.preventDefault();

    const callDuration = parseFloat($("#callDuration").val());
    let billAmount;
    let calcDetail = "";

    if (isNaN(callDuration) || callDuration < 0) {
      alert("請輸入有效的通話時長（正整數）");
      return;
    }

    // 計算電話費
    if (callDuration <= 600) {
      billAmount = callDuration * 0.5;
      let part1 = billAmount;
      let part2 = 0;
      let part3 = 0;
      calcDetail = `前600分鐘：${callDuration} × 0.5 = ${billAmount.toFixed(
        2
      )} 元`;
      calcDetail +=
        '<br><span style="color:#007bff;font-weight:bold;">計算金額四捨五入後為該月應繳金額</span>';
    } else if (callDuration <= 1200) {
      let part1 = 600 * 0.5;
      let part2 = (callDuration - 600) * 0.5 * 0.9;
      let part3 = 0;
      billAmount = part1 + part2;
      calcDetail = `前600分鐘：600 × 0.5 = ${part1.toFixed(
        2
      )} 元<br>第601~${callDuration}分鐘：${
        callDuration - 600
      } × 0.5 × 0.9 = ${part2.toFixed(2)} 元<br>總計：${(part1 + part2).toFixed(
        2
      )} 元`;
      calcDetail +=
        '<br><span style="color:#007bff;font-weight:bold;">計算金額四捨五入後為該月應繳金額</span>';
    } else {
      let part1 = 600 * 0.5;
      let part2 = 600 * 0.5 * 0.9;
      let part3 = (callDuration - 1200) * 0.5 * 0.79;
      billAmount = part1 + part2 + part3;
      calcDetail = `前600分鐘：600 × 0.5 = ${part1.toFixed(
        2
      )} 元<br>第601~1200分鐘：600 × 0.5 × 0.9 = ${part2.toFixed(
        2
      )} 元<br>第1201~${callDuration}分鐘：${
        callDuration - 1200
      } × 0.5 × 0.79 = ${part3.toFixed(2)} 元<br>總計：${(
        part1 +
        part2 +
        part3
      ).toFixed(2)} 元`;
      calcDetail +=
        '<br><span style="color:#007bff;font-weight:bold;">計算金額四捨五入後為該月應繳金額</span>';
    }
    // 四捨五入
    billAmount = Math.round(billAmount);

    $("section h2 span").text(` ${billAmount} 元`);
    // 顯示結果區塊
    $("section.result").show();
    // 顯示計算過程
    if ($("section .calc-detail").length === 0) {
      $("section h2").after(
        '<div class="calc-detail" style="margin:4px 0 10px 0;color:#555;"></div>'
      );
    }
    $("section .calc-detail").html(calcDetail);

    // 更新紀錄（保留最多12筆）
    let timestamp = Date.now();
    billHistory[timestamp] = {
      duration: callDuration,
      amount: billAmount,
      part1: typeof part1 !== "undefined" ? Math.round(part1) : 0,
      part2: typeof part2 !== "undefined" ? Math.round(part2) : 0,
      part3: typeof part3 !== "undefined" ? Math.round(part3) : 0,
    };
    // 只保留最新 12 筆
    let keys = Object.keys(billHistory);
    if (keys.length > 12) {
      delete billHistory[keys[0]];
    }

    // 顯示紀錄
    let $historyList = $("<ol></ol>");
    Object.values(billHistory).forEach(function (item) {
      let detail = `通話時長: ${item.duration} 分鐘, 電話費: ${item.amount} 元`;
      if (item.part1 > 0) detail += `，600分鐘內: ${item.part1} 元`;
      if (item.part2 > 0) detail += `，601~1200分鐘: ${item.part2} 元`;
      if (item.part3 > 0) detail += `，1201分鐘以上: ${item.part3} 元`;
      let $listItem = $("<li></li>").text(detail);
      $historyList.append($listItem);
    });
    $("section h4").html($historyList);

    // 顯示總金額（四捨五入）
    let total = 0;
    Object.values(billHistory).forEach(function (item) {
      total += item.amount;
    });
    total = Math.round(total);
    const summary = `<div>共 ${
      Object.keys(billHistory).length
    } 期帳單，金額一共是: ${total} 元</div>`;
    $("section h3").html(summary);

    // 清空輸入欄位
    $("#callDuration").val("");
  });
});
