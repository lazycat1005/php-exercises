// 19 英文字母大小寫驗證 - 合併自 version-2, version-4
$(document).ready(function () {
  $("#charInput").on("keypress", function (e) {
    const charCode = e.which || e.keyCode;
    // version-4: 允許 A-Z, a-z
    // version-2: 僅允許 A-Z
    // 若 input 有 data-allow-lower 屬性則允許小寫
    const allowLower =
      $(this).data("allow-lower") === true ||
      $(this).data("allow-lower") === "true";
    if (allowLower) {
      if (
        !(
          (charCode >= 65 && charCode <= 90) ||
          (charCode >= 97 && charCode <= 122)
        )
      ) {
        e.preventDefault();
        alert("請輸入英文字母 (A-Z, a-z)");
      }
    } else {
      if (!(charCode >= 65 && charCode <= 90)) {
        e.preventDefault();
        alert("請輸入大寫英文字母 (A-Z)");
      }
    }
  });

  // 禁止貼上非英文字母
  $("#charInput").on("paste", function (e) {
    e.preventDefault();
    const allowLower =
      $(this).data("allow-lower") === true ||
      $(this).data("allow-lower") === "true";
    alert(
      allowLower ? "請輸入英文字母 (A-Z, a-z)" : "請輸入大寫英文字母 (A-Z)"
    );
  });

  // version-2: 禁止從歷史下拉選單選擇非大寫英文字母
  $("#charInput").on("input", function () {
    const value = $(this).val();
    const allowLower =
      $(this).data("allow-lower") === true ||
      $(this).data("allow-lower") === "true";
    if (allowLower) {
      if (/[^A-Za-z]/.test(value)) {
        $(this).val(value.replace(/[^A-Za-z]/g, ""));
        alert("請輸入英文字母 (A-Z, a-z)");
      }
    } else {
      if (/[^A-Z]/.test(value)) {
        $(this).val(value.replace(/[^A-Z]/g, ""));
        alert("請輸入大寫英文字母 (A-Z)");
      }
    }
  });
});
