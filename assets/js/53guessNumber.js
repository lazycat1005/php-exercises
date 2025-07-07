let answer = null;
let guessed = false;
let revealed = false;
let guessedNumbers = [];

function resetGame() {
  answer = Math.floor(Math.random() * 100) + 1;
  guessed = false;
  revealed = false;
  guessedNumbers = [];
  $("#message").text("已產生 1~100 的隨機數，請開始猜！");
  $("#btnStart").prop("disabled", true);
  $("#btnReveal").prop("disabled", false);
  $("#guess").prop("disabled", false).val("");
  $("#btnSubmit").prop("disabled", false);
  $("#guessedNumbers").text("");
}

function endGame(msg) {
  $("#message").text(msg);
  $("#btnStart").prop("disabled", false);
  $("#btnReveal").prop("disabled", true);
  $("#guess").prop("disabled", true);
  $("#btnSubmit").prop("disabled", true);
}

function updateGuessedNumbers() {
  $("#guessedNumbers").text(guessedNumbers.join(", "));
}

$(function () {
  $("#btnStart").on("click", function () {
    resetGame();
  });

  $("#btnSubmit").on("click", function () {
    if (guessed || revealed) return;
    const guess = parseInt($("#guess").val(), 10);
    if (isNaN(guess) || guess < 1 || guess > 100) {
      $("#message").text("請輸入 1~100 的整數");
      return;
    }
    // 若已猜過此數字則不重複加入
    if (!guessedNumbers.includes(guess)) {
      guessedNumbers.push(guess);
      updateGuessedNumbers();
    }
    if (guess === answer) {
      guessed = true;
      endGame("猜對了！答案是 " + answer + "。");
    } else if (guess > answer) {
      $("#message").text("太大了");
    } else {
      $("#message").text("太小了");
    }
  });

  $("#btnReveal").on("click", function () {
    if (answer === null) return;
    revealed = true;
    endGame("答案是：" + answer);
  });

  // 預設狀態
  $("#btnStart").prop("disabled", false);
  $("#btnReveal").prop("disabled", true);
  $("#guess").prop("disabled", true);
  $("#btnSubmit").prop("disabled", true);

  // 按 Enter 也能送出
  $("#guess").on("keypress", function (e) {
    if (e.which === 13 && !$("#btnSubmit").prop("disabled")) {
      $("#btnSubmit").click();
    }
  });
});
