$(document).ready(function () {
  const billHistory = [];

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
    billHistory.push(
      `通話時長: ${callDuration} 分鐘, 電話費: ${billAmount} 元`
    );
    if (billHistory.length > 12) {
      billHistory.shift();
    }

    // 顯示紀錄
    const historyList = $("<ol></ol>");
    billHistory.forEach(function (item) {
      const listItem = $("<li></li>").text(item);
      historyList.append(listItem);
    });
    $("section h4").html(historyList);

    // 顯示總金額（四捨五入）
    let total = 0;
    billHistory.forEach(function (item) {
      const match = item.match(/電話費: ([\d.]+) 元/);
      if (match) {
        total += parseFloat(match[1]);
      }
    });
    total = Math.round(total);
    const summary = `<div>共 ${billHistory.length} 期帳單，金額一共是: ${total} 元</div>`;
    $("section h3").html(summary);

    // 清空輸入欄位
    $("#callDuration").val("");
  });
});
