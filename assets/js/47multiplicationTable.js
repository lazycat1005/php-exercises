// 47 乘法表 - 合併自 version-2, version-3
// 表單驗證（兩版本相同）
$("#tableForm").on("submit", function (e) {
  const input = $("#tableCount").val();
  // 僅允許數字、逗號、全形逗號、~、-、空白
  const valid = /^[0-9,\uff0c~\- ]+$/.test(input);
  if (!valid) {
    $("#inputError").text(
      "請勿輸入文字、科學符號、運算符號、小數點或超過9的數字"
    );
    e.preventDefault();
    return;
  }
  // 檢查是否有超過9的數字
  const cleaned = input.replace(/[\uff0c ]/g, ",");
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

// version-3: 互動小遊戲邏輯
$(function () {
  const $inputs = $(".answer-input");
  if ($inputs.length > 0) {
    $inputs.eq(0).prop("disabled", false).focus();
  }

  $inputs.on("keydown", function (e) {
    // 只允許數字與 Enter
    if (
      !(e.key >= "0" && e.key <= "9") &&
      e.key !== "Backspace" &&
      e.key !== "Tab" &&
      e.key !== "Enter" &&
      e.key !== "ArrowLeft" &&
      e.key !== "ArrowRight"
    ) {
      e.preventDefault();
    }
  });

  $inputs.on("input", function () {
    // 移除非數字
    this.value = this.value.replace(/[^0-9]/g, "");
  });

  $inputs.on("keyup", function (e) {
    if (e.key !== "Enter") return;
    const $this = $(this);
    const ans = $this.data("ans").toString();
    const val = $this.val();
    const idx = parseInt($this.data("qidx"), 10);
    const $label = $("#label-" + $this.attr("id"));
    const $fb = $("#fb-" + $this.attr("id"));

    if (val === ans) {
      $label.css("color", "green");
      $fb.text("✔").css("color", "green");
      $this.prop("disabled", true);
      // 啟用下一題
      const $next = $inputs.eq(idx + 1);
      if ($next.length) {
        $next.prop("disabled", false).focus();
      }
    } else {
      $label.css("color", "red");
      $fb.text("✘").css("color", "red");
    }
  });

  // 若有題目被重設，移除顏色
  $inputs.on("focus", function () {
    const $label = $("#label-" + $(this).attr("id"));
    const $fb = $("#fb-" + $(this).attr("id"));
    $label.css("color", "");
    $fb.text("");
  });
});
