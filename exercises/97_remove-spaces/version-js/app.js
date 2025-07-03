// 當輸入框失去焦點時，清除字串中的空格並更新輸入框的值
// 使用正則表達式 /\s+/g 來匹配所有空格
$(document).ready(function () {
  $("#inputForm").on("submit", function (e) {
    e.preventDefault();
  });
  $("#inputString").on("blur", function () {
    const inputString = $(this).val();
    const filteredString = inputString.replace(/\s+/g, "");
    $(this).val(filteredString);
    $("#message").text("字串已更動");
  });
});
