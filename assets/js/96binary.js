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
  const inputValue = document.getElementById("binaryInput").value;
  try {
    const { binaryStr, onesCount } = decimalToBinaryAndCountOnes(inputValue);
    document.getElementById(
      "result"
    ).innerHTML = `二進位：${binaryStr}<br>1 的個數：${onesCount}`;
  } catch (error) {
    document.getElementById("result").innerHTML = error.message;
  }
}

// 處理 Form1 的提交
function handleDivideByTwoSubmit(event) {
  event.preventDefault();
  const inputValue = document.getElementById("binaryInput").value;
  try {
    const result = divideByTwoRecursively(inputValue);
    let output = "<h3>除以 2 的結果：</h3><ul>";
    const remainders = [];
    result.forEach((item) => {
      output += `<li>層級 ${item.level}：商 ${item.quotient}，餘數 ${item.remainder}</li>`;
      remainders.push(item.remainder);
    });
    output += "</ul>";
    // 倒序顯示餘數，組成二進位
    const binaryStr = remainders.reverse().join("");
    output += `<div>倒序餘數（二進位）：${binaryStr}</div>`;
    // 計算二進位中有多少個1
    const onesCount = binaryStr.split("").filter((c) => c === "1").length;
    output += `<div>1 的個數：${onesCount}</div>`;
    document.getElementById("result").innerHTML = output;
  } catch (error) {
    document.getElementById("result").innerHTML = error.message;
  }
}

// 綁定表單事件（加上判斷）
const form1 = document.getElementById("binaryForm1");
if (form1) {
  form1.addEventListener("submit", handleDivideByTwoSubmit);
}

const form2 = document.getElementById("binaryForm2");
if (form2) {
  form2.addEventListener("submit", handleSubmit);
}
