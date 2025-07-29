//前端驗證輸入的發票號碼是否為有效的數字
$(function () {
  $(".receiptForm").on("submit", function (event) {
    let $receiptInput = $("#receipt");
    let $receiptValue = $receiptInput.val().trim();

    // 檢查是否為3~8位數字
    if (!/^\d{3,8}$/.test($receiptValue)) {
      event.preventDefault();
      $(".errorMessage").text("請輸入有效的發票號碼（3~8位數字）!!");
    }
  });
});
