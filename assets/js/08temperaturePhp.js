// 08 溫度單位轉換 - PHP 版本專用
$(function () {
  const $celsiusInput = $('input[name="celsius"]');
  const $fahrenheitInput = $('input[name="fahrenheit"]');
  const $toCelsiusBtn = $('button[value="toCelsius"]');
  const $toFahrenheitBtn = $('button[value="toFahrenheit"]');
  const $clearBtn = $("#clearBtn");

  // 初始化所有事件監聽器
  initEventListeners();

  /**
   * 初始化所有事件監聽器
   */
  function initEventListeners() {
    bindEnterKeySubmission();
    bindClearButtonEvent();
  }

  /**
   * 綁定 Enter 鍵提交事件
   */
  function bindEnterKeySubmission() {
    $celsiusInput.add($fahrenheitInput).on("keydown", function (e) {
      if (e.keyCode === 13) {
        e.preventDefault();
        handleEnterKeySubmission(this);
      }
    });
  }

  /**
   * 處理 Enter 鍵提交邏輯
   * @param {HTMLElement} input - 觸發事件的輸入框元素
   */
  function handleEnterKeySubmission(input) {
    const $inputValue = $.trim(input.value);

    if ($inputValue === "") {
      return;
    }

    if (input.name === "celsius") {
      $toFahrenheitBtn.click();
    } else if (input.name === "fahrenheit") {
      $toCelsiusBtn.click();
    }
  }

  /**
   * 綁定清除按鈕事件
   */
  function bindClearButtonEvent() {
    $clearBtn.on("click", function () {
      clearPageAndRedirect();
    });
  }

  /**
   * 清除頁面並重新導向 - 使用 PRG 模式重新導向到乾淨的頁面
   */
  function clearPageAndRedirect() {
    window.location.href = window.location.pathname;
  }
});
