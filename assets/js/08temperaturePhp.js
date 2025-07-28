// 08 溫度單位轉換 - PHP 版本專用
$(function () {
  const $celsiusInput = $('input[name="celsius"]');
  const $fahrenheitInput = $('input[name="fahrenheit"]');
  const $toCelsiusBtn = $('button[value="toCelsius"]');
  const $toFahrenheitBtn = $('button[value="toFahrenheit"]');
  const $clearBtn = $("#clearBtn");

  // 處理 Enter 鍵提交
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

  // 清除按鈕功能 - 使用 PRG 模式重新導向到乾淨的頁面
  $clearBtn.on("click", () => {
    window.location.href = window.location.pathname;
  });
});
