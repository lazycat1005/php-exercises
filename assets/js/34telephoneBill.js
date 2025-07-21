// 34 電話費計算 - 合併自 version-js
$(function () {
  let billHistory = {};

  $("form").on("submit", function (event) {
    event.preventDefault();

    const callDuration = parseFloat($("#callDuration").val());
    let billAmount;

    if (isNaN(callDuration) || callDuration < 0) {
      alert("請輸入有效的通話時長（正整數）");
      return;
    }

    // 計算電話費
    if (callDuration <= 600) {
      billAmount = callDuration * 0.5;
    } else if (callDuration <= 1200) {
      billAmount = 600 * 0.5 + (callDuration - 600) * 0.5 * 0.9;
    } else {
      billAmount =
        600 * 0.5 + 600 * 0.5 * 0.9 + (callDuration - 1200) * 0.5 * 0.79;
    }
    // 四捨五入
    billAmount = Math.round(billAmount);

    $("section h2 span").text(` ${billAmount} 元`);

    // 更新紀錄（保留最多12筆）
    let timestamp = Date.now();
    billHistory[timestamp] = {
      callDuration,
      billAmount,
    };
    // 只保留最新 12 筆
    let keys = Object.keys(billHistory);
    if (keys.length > 12) {
      delete billHistory[keys[0]];
    }

    // 顯示紀錄
    let $historyList = $("<ol></ol>");
    Object.values(billHistory).forEach(function (item) {
      let $listItem = $("<li></li>").text(
        `通話時長: ${item.callDuration} 分鐘, 電話費: ${item.billAmount} 元`
      );
      $historyList.append($listItem);
    });
    $("section h4").html($historyList);

    // 顯示總金額（四捨五入）
    let total = 0;
    Object.values(billHistory).forEach(function (item) {
      total += item.billAmount;
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
