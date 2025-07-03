// 僅可輸入英文字母，利用 JQuery 驗證，"按鍵當下"不是英文，就不給輸入，使用者貼上也不行
$(document).ready(function () {
  $("#charInput").on("keypress", function (e) {
    const charCode = e.which || e.keyCode;
    // 檢查是否為英文字母
    if (
      !(
        (charCode >= 65 && charCode <= 90) ||
        (charCode >= 97 && charCode <= 122)
      )
    ) {
      e.preventDefault(); // 阻止輸入
      alert("請輸入英文字母 (A-Z, a-z)");
    }
  });

  // 禁止貼上非英文字母
  $("#charInput").on("paste", function (e) {
    e.preventDefault(); // 阻止貼上
    alert("請輸入英文字母 (A-Z, a-z)");
  });
});
