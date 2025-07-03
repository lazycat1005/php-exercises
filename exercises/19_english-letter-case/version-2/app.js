// 提供一個輸入框，僅可輸入大寫英文字母，利用 JQuery 判斷，"按鍵當下"不是大寫英文，就不給輸入，使用者貼上也不行
$(document).ready(function () {
  $("#charInput").on("keypress", function (e) {
    const charCode = e.which || e.keyCode;
    // 檢查是否為大寫英文字母
    if (!(charCode >= 65 && charCode <= 90)) {
      e.preventDefault(); // 阻止輸入
      alert("請輸入大寫英文字母 (A-Z)");
    }
  });

  // 禁止貼上非大寫英文字母
  $("#charInput").on("paste", function (e) {
    e.preventDefault(); // 阻止貼上
    alert("請輸入大寫英文字母 (A-Z)");
  });

  //禁止從歷史下拉視窗中選擇非大寫字母
  $("#charInput").on("input", function () {
    const value = $(this).val();
    // 檢查是否包含非大寫英文字母
    if (/[^A-Z]/.test(value)) {
      $(this).val(value.replace(/[^A-Z]/g, "")); // 移除非大寫字母
      alert("請輸入大寫英文字母 (A-Z)");
    }
  });
});
