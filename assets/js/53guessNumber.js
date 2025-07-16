let answer = null;
let guessed = false;
let revealed = false;
let guessedNumbers = [];

// 重置遊戲狀態
// 生成新的隨機數，重置猜測狀態和已猜測數字列表
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

// 結束遊戲並顯示結果
// 顯示結束訊息，禁用相關按鈕
function endGame(msg) {
  $("#message").text(msg);
  $("#btnStart").prop("disabled", false);
  $("#btnReveal").prop("disabled", true);
  $("#guess").prop("disabled", true);
  $("#btnSubmit").prop("disabled", true);
}

// 更新已猜測的數字列表
// 將已猜測的數字顯示在頁面上
function updateGuessedNumbers() {
  $("#guessedNumbers").text(guessedNumbers.join(", "));
}

// 當頁面載入時，初始化遊戲
// 綁定按鈕事件，設置初始狀態
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
