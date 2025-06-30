$(document).ready(() => {
  // 數字輸入驗證（僅允許數字、小數點、負號）
  const validateNumericInput = (input) => {
    const value = input.val();
    const numericPattern = /^-?\d*\.?\d*$/;

    if (!numericPattern.test(value)) {
      const cleanValue = value.replace(/[^-\d.]/g, "");
      input.val(cleanValue);
    }
  };

  // 即時驗證輸入
  $("#fahrenheit, #celsius").on("input", function () {
    validateNumericInput($(this));

    // 移除錯誤樣式
    $(this).removeClass("is-invalid");
    $(this).siblings(".invalid-feedback").hide();
  });

  // 防止貼上非數字內容
  $("#fahrenheit, #celsius").on("paste", function (e) {
    e.preventDefault();
    const pastedText = (
      e.originalEvent.clipboardData || window.clipboardData
    ).getData("text");
    const numericText = pastedText.replace(/[^-\d.]/g, "");
    $(this).val(numericText);
    validateNumericInput($(this));
  });

  // 表單提交前驗證
  $("#fahrenheitForm, #celsiusForm").on("submit", function (e) {
    const input = $(this).find('input[type="text"]');
    const value = input.val().trim();

    if (value === "") {
      e.preventDefault();
      input.addClass("is-invalid");

      // 動態顯示錯誤訊息
      let errorMsg = input.siblings(".invalid-feedback");
      if (errorMsg.length === 0) {
        errorMsg = $('<div class="invalid-feedback"></div>');
        input.parent().append(errorMsg);
      }
      errorMsg.text("請輸入有效的溫度值").show();

      // 聚焦到錯誤的輸入框
      input.focus();
      return false;
    }

    // 檢查是否為有效數字
    if (isNaN(parseFloat(value))) {
      e.preventDefault();
      input.addClass("is-invalid");

      let errorMsg = input.siblings(".invalid-feedback");
      if (errorMsg.length === 0) {
        errorMsg = $('<div class="invalid-feedback"></div>');
        input.parent().append(errorMsg);
      }
      errorMsg.text("請輸入有效的數字").show();

      input.focus();
      return false;
    }
  });

  // 清除另一個輸入框當前輸入框有值時
  $("#fahrenheit").on("input", function () {
    if ($(this).val().trim() !== "") {
      $("#celsius").val("");
    }
  });

  $("#celsius").on("input", function () {
    if ($(this).val().trim() !== "") {
      $("#fahrenheit").val("");
    }
  });

  // 自動聚焦到第一個輸入框
  if ($("#fahrenheit").val() === "" && $("#celsius").val() === "") {
    $("#fahrenheit").focus();
  }
});
