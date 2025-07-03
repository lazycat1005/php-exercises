document.addEventListener("DOMContentLoaded", () => {
  const celsiusInput = document.querySelector('input[name="celsius"]');
  const fahrenheitInput = document.querySelector('input[name="fahrenheit"]');
  const toCelsiusBtn = document.querySelector('button[value="toCelsius"]');
  const toFahrenheitBtn = document.querySelector(
    'button[value="toFahrenheit"]'
  );

  // 綁定 keydown 事件
  [celsiusInput, fahrenheitInput].forEach((input) => {
    input.addEventListener("keydown", function (e) {
      if (e.key === "Enter") {
        e.preventDefault(); // 阻止預設送出行為

        // 根據哪個欄位有值來決定按哪個按鈕
        if (this.name === "celsius" && this.value.trim() !== "") {
          toFahrenheitBtn.click();
        } else if (this.name === "fahrenheit" && this.value.trim() !== "") {
          toCelsiusBtn.click();
        }
      }
    });
  });

  // 清除事件
  const clearBtn = document.getElementById("clearBtn");
  const messageBox = document.querySelector(".messageText");

  clearBtn.addEventListener("click", () => {
    celsiusInput.value = "";
    fahrenheitInput.value = "";
    messageBox.innerHTML = "";
  });
});
