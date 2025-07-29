/**
 * 移除字串中所有空格
 * @param {string} str - 要處理的字串
 * @returns {string} 移除空格後的字串
 */
function removeAllSpaces(str) {
  return str.replace(/\s+/g, "");
}

/**
 * 顯示操作訊息
 * @param {string} message - 要顯示的訊息
 */
function showMessage(message) {
  $("#message").text(message);
}

/**
 * 處理輸入框失去焦點事件
 */
function handleInputBlur() {
  const $inputString = $("#inputString");
  const inputValue = $inputString.val();
  const filteredValue = removeAllSpaces(inputValue);

  $inputString.val(filteredValue);
  showMessage("字串已更動");
}

/**
 * 防止表單預設提交行為
 * @param {Event} e - 事件物件
 */
function preventFormSubmit(e) {
  e.preventDefault();
}

/**
 * 初始化事件監聽器
 */
function initEventListeners() {
  $("#inputForm").on("submit", preventFormSubmit);
  $("#inputString").on("blur", handleInputBlur);
}

// 當 DOM 載入完成後執行初始化
$(function () {
  initEventListeners();
});
