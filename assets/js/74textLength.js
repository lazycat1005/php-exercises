// 74 計算文字長度 - 合併自 version-1, version-2, version-4
// 依據不同頁面功能自動啟用對應邏輯

$(document).ready(function () {
  // version-4: 實時顯示字元數並限制最大 100 字
  if ($("#version4").length) {
    $("#version4").on("input", function () {
      const text = $(this).val();
      const charCount = text.length;
      $("#charCount").text("字元個數: " + charCount);
      // 超過 100 字自動限制
      if (charCount >= 100) {
        $(this).attr("maxlength", "100");
      } else {
        $(this).removeAttr("maxlength");
      }
    });
  }

  // version-1: 表單送出時驗證（空值或超過 1000 字）
  $("form").on("submit", function (e) {
    const text = $('textarea[name="text"]').val();
    if (typeof text === "string") {
      const trimmed = text.trim();
      if (trimmed.length === 0) {
        alert("請輸入文字");
        e.preventDefault();
      } else if (trimmed.length > 1000) {
        alert("字數不可超過 1000 字");
        e.preventDefault();
      }
    }
  });
});

// version-2: 提供外部呼叫的字元計算函數
function text74CountChars(textarea) {
  const text = $(textarea).val();
  const charCount = text.length;
  $("#charCount").text("字元個數: " + charCount);
}
