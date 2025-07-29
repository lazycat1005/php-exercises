// 08 溫度單位轉換 - AJAX 版本專用
$(function () {
  let $errorMessage = $(".messageText");

  /**
   * 取得對應的輸入框
   * @param {jQuery} $currentInput 當前輸入框
   * @returns {jQuery} 對應的另一個輸入框
   */
  function getTargetInput($currentInput) {
    return $currentInput.attr("id") === "celsius"
      ? $("#fahrenheit")
      : $("#celsius");
  }

  /**
   * 重置表單狀態
   * @param {jQuery} $targetInput 要重置的目標輸入框
   */
  function resetFormState($targetInput) {
    $targetInput.prop("disabled", false);
    $targetInput.val("");
    $errorMessage.text("");
  }

  /**
   * 驗證輸入值是否有效
   * @param {string} inputVal 輸入值
   * @returns {boolean} 是否有效
   */
  function validateInput(inputVal) {
    if (!$.isNumeric(inputVal)) {
      $errorMessage.text("請輸入有效的數字。");
      return false;
    }

    if (/e/i.test(inputVal)) {
      $errorMessage.text("無效的值");
      return false;
    }

    return true;
  }

  /**
   * 處理 AJAX 回傳資料
   * @param {*} data 伺服器回傳資料
   * @param {jQuery} $currentInput 當前輸入框
   * @param {jQuery} $targetInput 目標輸入框
   */
  function handleAjaxResponse(data, $currentInput, $targetInput) {
    try {
      let result = typeof data === "string" ? JSON.parse(data) : data;
      if (result.success) {
        let targetValue =
          $currentInput.attr("id") === "celsius"
            ? result.fahrenheit
            : result.celsius;
        $targetInput.val(targetValue);
        $errorMessage.text("");
      } else {
        $errorMessage.text(result.message || "轉換失敗");
      }
    } catch (e) {
      $errorMessage.text("伺服器返回資料格式錯誤");
    }
  }

  /**
   * 執行溫度轉換 AJAX 請求
   * @param {string} inputVal 輸入值
   * @param {jQuery} $currentInput 當前輸入框
   * @param {jQuery} $targetInput 目標輸入框
   */
  function performTemperatureConversion(inputVal, $currentInput, $targetInput) {
    $.ajax({
      url: (window.webRoot || "") + "ajax/temperature.php",
      type: "POST",
      data: {
        temperature: inputVal,
        unit: $currentInput.attr("id"),
      },
      success: function (data) {
        handleAjaxResponse(data, $currentInput, $targetInput);
      },
      error: function () {
        $errorMessage.text("轉換失敗，請稍後再試。");
      },
    });
  }

  /**
   * 處理輸入框變更事件
   */
  function handleInputChange() {
    const $this = $(this);
    let $otherInput = getTargetInput($this);
    let inputVal = $this.val();

    if (inputVal !== "") {
      $otherInput.prop("disabled", true);
    } else {
      resetFormState($otherInput);
      return;
    }

    if (validateInput(inputVal)) {
      performTemperatureConversion(inputVal, $this, $otherInput);
    } else {
      $otherInput.val("");
    }
  }

  // 綁定事件
  $("#celsius, #fahrenheit").on("input", handleInputChange);
});
