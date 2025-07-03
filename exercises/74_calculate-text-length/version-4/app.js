$(document).ready(function () {
  $("textarea").on("input", function () {
    const text = $(this).val();
    const charCount = text.length;
    $("#charCount").text("字元個數: " + charCount);

    // 如果超過 100 個字，就不允許再輸入
    if (charCount >= 100) {
      $(this).attr("maxlength", "100");
    } else {
      $(this).removeAttr("maxlength");
    }
  });
});
