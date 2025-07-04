// 08 溫度單位轉換 - 合併自 version-ajax, version-php
$(document).ready(function () {
  // 判斷是否為 AJAX 版本（有 #celsius, #fahrenheit, .messageText p）
  const isAjaxVersion =
    $("#celsius").length &&
    $("#fahrenheit").length &&
    $(".messageText p").length;

  if (isAjaxVersion) {
    // AJAX 版本
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
        if (/e/i.test(inputVal)) {
          errorMessage.text("無效的值");
          $(otherInput).val("");
          return;
        }
        $.ajax({
          url: "/PHP-Exercises/app/ajax/temperature.php",
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
  } else {
    // PHP 版本
    const $celsiusInput = $('input[name="celsius"]');
    const $fahrenheitInput = $('input[name="fahrenheit"]');
    const $toCelsiusBtn = $('button[value="toCelsius"]');
    const $toFahrenheitBtn = $('button[value="toFahrenheit"]');
    const $clearBtn = $("#clearBtn");
    const $messageBox = $(".messageText");
    $celsiusInput.add($fahrenheitInput).on("keydown", function (e) {
      if (e.keyCode === 13) {
        e.preventDefault();
        if (this.name === "celsius" && $.trim(this.value) !== "") {
          $toFahrenheitBtn.click();
        } else if (this.name === "fahrenheit" && $.trim(this.value) !== "") {
          $toCelsiusBtn.click();
        }
      }
    });
    $clearBtn.on("click", function () {
      $celsiusInput.val("");
      $fahrenheitInput.val("");
      $messageBox.html("");
    });
  }
});
