// version-2: 提供外部呼叫的字元計算函數
function text74CountChars(textarea) {
  const text = $(textarea).val();
  const charCount = text.length;
  $("#charCount").text("字元個數: " + charCount);
}

// version-4: 實時顯示字元數並限制最大 100 字
$(function () {
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
});
