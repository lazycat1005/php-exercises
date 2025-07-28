// 08 溫度單位轉換 - AJAX 版本專用
$(function () {
  let $errorMessage = $(".messageText");

  $("#celsius, #fahrenheit").on("input", function () {
    const $this = $(this);
    let $otherInput =
      $this.attr("id") === "celsius" ? $("#fahrenheit") : $("#celsius");
    let inputVal = $this.val();

    if (inputVal !== "") {
      $otherInput.prop("disabled", true);
    } else {
      $otherInput.prop("disabled", false);
      $otherInput.val("");
      $errorMessage.text("");
      return;
    }

    if ($.isNumeric(inputVal)) {
      if (/e/i.test(inputVal)) {
        $errorMessage.text("無效的值");
        $otherInput.val("");
        return;
      }

      $.ajax({
        url: (window.webRoot || "") + "ajax/temperature.php",
        type: "POST",
        data: {
          temperature: inputVal,
          unit: $this.attr("id"),
        },
        success: function (data) {
          try {
            let result = typeof data === "string" ? JSON.parse(data) : data;
            if (result.success) {
              let targetValue =
                $this.attr("id") === "celsius"
                  ? result.fahrenheit
                  : result.celsius;
              $otherInput.val(targetValue);
              $errorMessage.text("");
            } else {
              $errorMessage.text(result.message || "轉換失敗");
            }
          } catch (e) {
            $errorMessage.text("伺服器返回資料格式錯誤");
          }
        },
        error: function () {
          $errorMessage.text("轉換失敗，請稍後再試。");
        },
      });
    } else {
      $errorMessage.text("請輸入有效的數字。");
      $otherInput.val("");
    }
  });
});
