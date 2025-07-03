$(document).ready(function () {
  const errorMessage = $(".messageText p");

  $("#celsius, #fahrenheit").on("input", function () {
    const $this = $(this);
    const otherInput =
      $this.attr("id") === "celsius" ? "#fahrenheit" : "#celsius";

    const inputVal = $this.val();

    if (inputVal !== "") {
      $(otherInput).prop("disabled", true);
    } else {
      $(otherInput).prop("disabled", false);
      $(otherInput).val("");
      errorMessage.text("");
      return;
    }

    if ($.isNumeric(inputVal)) {
      // 檢查是否為科學記號格式（如 1e10、2E5 等）
      if (/e/i.test(inputVal)) {
        errorMessage.text("無效的值");
        $(otherInput).val("");
        return;
      }
      $.ajax({
        url: "./php/convert.php",
        type: "POST",
        data: {
          temperature: inputVal,
          unit: $this.attr("id"),
        },
        success: function (data) {
          try {
            const result = typeof data === "string" ? JSON.parse(data) : data;

            if (result.success) {
              const targetValue =
                $this.attr("id") === "celsius"
                  ? result.fahrenheit
                  : result.celsius;
              $(otherInput).val(targetValue);
              errorMessage.text("");
            } else {
              errorMessage.text(result.message || "轉換失敗");
            }
          } catch (e) {
            errorMessage.text("伺服器返回資料格式錯誤");
          }
        },
        error: function () {
          errorMessage.text("轉換失敗，請稍後再試。");
        },
      });
    } else {
      errorMessage.text("請輸入有效的數字。");
      $(otherInput).val("");
    }
  });
});
