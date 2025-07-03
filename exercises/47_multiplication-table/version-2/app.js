// 前端驗證
$("#tableForm").on("submit", function (e) {
  const input = $("#tableCount").val();
  // 僅允許數字、逗號、全形逗號、~、-、空白
  const valid = /^[0-9,，~\- ]+$/.test(input);
  if (!valid) {
    $("#inputError").text(
      "請勿輸入文字、科學符號、運算符號、小數點或超過9的數字"
    );
    e.preventDefault();
    return;
  }
  // 檢查是否有超過9的數字
  const cleaned = input.replace(/[， ]/g, ",");
  const parts = cleaned.split(",");
  for (const part of parts) {
    if (part.includes("~") || part.includes("-")) {
      const range = part.split(/~|-/);
      if (range.length === 2) {
        const start = parseInt(range[0], 10);
        const end = parseInt(range[1], 10);
        if (start > 9 || end > 9) {
          $("#inputError").text("請勿輸入超過9的數字");
          e.preventDefault();
          return;
        }
      }
    } else if (part !== "" && !isNaN(part)) {
      if (parseInt(part, 10) > 9) {
        $("#inputError").text("請勿輸入超過9的數字");
        e.preventDefault();
        return;
      }
    }
  }
  $("#inputError").text("");
});
// 若後端有錯誤訊息，顯示於前端
if (window.inputErrorMsg) {
  $("#inputError").text(window.inputErrorMsg);
}
