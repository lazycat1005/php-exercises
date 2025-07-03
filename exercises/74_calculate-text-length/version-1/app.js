// 前端驗證與輸入限制
$(function () {
  $("form").on("submit", function (e) {
    const text = $('textarea[name="text"]').val().trim();
    if (text.length === 0) {
      alert("請輸入文字");
      e.preventDefault();
    } else if (text.length > 1000) {
      alert("字數不可超過 1000 字");
      e.preventDefault();
    }
  });
});
