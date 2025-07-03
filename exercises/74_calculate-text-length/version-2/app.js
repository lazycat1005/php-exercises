// 當使用者輸入完且沒有專注在textarea上時，計算字元個數
function countChars(textarea) {
  const text = $(textarea).val();
  const charCount = text.length;
  $("#charCount").text("字元個數: " + charCount);
}
