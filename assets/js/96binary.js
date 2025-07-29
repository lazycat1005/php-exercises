// 共同驗證的邏輯
function isValidBinaryInput(value) {
  if (!/^[1-9][0-9]{0,2}$/.test(value)) {
    return false;
  }
  const num = Number(value);
  return Number.isInteger(num) && num >= 1 && num <= 256;
}

// 十進位轉二進位並計算 1 的個數 (Form2)
function decimalToBinaryAndCountOnes(value) {
  if (!isValidBinaryInput(value)) {
    throw new Error("請輸入 1~256 的正整數");
  }
  const num = Number(value);
  const binaryStr = num.toString(2);
  const onesCount = binaryStr.split("").filter((c) => c === "1").length;
  return { binaryStr, onesCount };
}

// 遞迴除以 2 並返回階層與餘數 (Form1)
function divideByTwoRecursively(value) {
  if (!isValidBinaryInput(value)) {
    throw new Error("請輸入 1~256 的正整數");
  }
  const num = Number(value);
  const result = [];
  function recurse(n, level) {
    if (n === 0) return;
    const quotient = Math.floor(n / 2);
    const remainder = n % 2;
    result.push({ level, quotient, remainder });
    recurse(quotient, level + 1);
  }
  recurse(num, 1);

  return result;
}

// 處理 Form2 的提交
function handleSubmit(event) {
  event.preventDefault();
  const inputValue = $("#binaryInput").val();
  try {
    const { binaryStr, onesCount } = decimalToBinaryAndCountOnes(inputValue);
    $("#resultSection").html(`二進位：${binaryStr}<br>1 的個數：${onesCount}`);
  } catch (error) {
    $("#resultSection").html(error.message);
  }
}

// 處理 Form1 的提交
function handleDivideByTwoSubmit(e) {
  e.preventDefault();
  const inputValue = $("#binaryInput").val();
  try {
    const result = divideByTwoRecursively(inputValue);
    let output = "<h2>計算結果：</h2>";
    output +=
      "<table><thead><tr><th>層級</th><th>商</th><th>餘數</th></tr></thead><tbody>";
    const remainders = [];
    result.forEach((item) => {
      output += `<tr><td>${item.level}</td><td>${item.quotient}</td><td>${item.remainder}</td></tr>`;
      remainders.push(item.remainder);
    });
    output += "</tbody></table>";
    // 倒序顯示餘數，組成二進位
    const binaryStr = remainders.reverse().join("");
    output += `<div>倒序餘數（二進位）：${binaryStr}</div>`;
    // 計算二進位中有多少個1
    const onesCount = binaryStr.split("").filter((c) => c === "1").length;
    output += `<div>1 的個數：${onesCount}</div>`;
    $("#resultSection").html(output);
  } catch (error) {
    $("#resultSection").html(error.message);
  }
}

// 綁定表單事件（加上判斷）
$(function () {
  const $form1 = $("#binaryForm1");
  if ($form1.length) {
    $form1.on("submit", handleDivideByTwoSubmit);
  }

  const $form2 = $("#binaryForm2");
  if ($form2.length) {
    $form2.on("submit", handleSubmit);
  }
});
