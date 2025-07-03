$(function () {
  const $celsiusInput = $('input[name="celsius"]');
  const $fahrenheitInput = $('input[name="fahrenheit"]');
  const $toCelsiusBtn = $('button[value="toCelsius"]');
  const $toFahrenheitBtn = $('button[value="toFahrenheit"]');
  const $clearBtn = $('#clearBtn');
  const $messageBox = $('.messageText');

  // 綁定 keydown 事件
  $celsiusInput.add($fahrenheitInput).on('keydown', function (e) {
    if (e.keyCode === 13) { // 13 = Enter
      e.preventDefault();
      // 根據哪個欄位有值來決定按哪個按鈕
      if (this.name === 'celsius' && $.trim(this.value) !== '') {
        $toFahrenheitBtn.click();
      } else if (this.name === 'fahrenheit' && $.trim(this.value) !== '') {
        $toCelsiusBtn.click();
      }
    }
  });

  // 清除事件
  $clearBtn.on('click', function () {
    $celsiusInput.val('');
    $fahrenheitInput.val('');
    $messageBox.html('');
  });
});
