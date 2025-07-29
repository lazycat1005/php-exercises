// 遊戲狀態變數
let $answer = null;
let $guessed = false;
let $revealed = false;
let $guessedNumbers = [];

// 生成 1-100 的隨機數字
function generateRandomAnswer() {
  return Math.floor(Math.random() * 100) + 1;
}

// 重置遊戲狀態
function resetGameState() {
  $answer = generateRandomAnswer();
  $guessed = false;
  $revealed = false;
  $guessedNumbers = [];
}

// 更新遊戲訊息顯示
function updateGameMessage(message) {
  $("#message").text(message);
}

// 設定按鈕狀態
function setButtonStates(
  startDisabled,
  revealDisabled,
  inputDisabled,
  submitDisabled
) {
  $("#btnStart").prop("disabled", startDisabled);
  $("#btnReveal").prop("disabled", revealDisabled);
  $("#guess").prop("disabled", inputDisabled);
  $("#btnSubmit").prop("disabled", submitDisabled);
}

// 清空輸入欄位
function clearInputField() {
  $("#guess").val("");
}

// 重置遊戲狀態
// 生成新的隨機數，重置猜測狀態和已猜測數字列表
function resetGame() {
  resetGameState();
  updateGameMessage("已產生 1~100 的隨機數，請開始猜！");
  setButtonStates(true, false, false, false);
  clearInputField();
  $("#guessedNumbers").text("");
}

// 結束遊戲並顯示結果
// 顯示結束訊息，禁用相關按鈕
function endGame(msg) {
  updateGameMessage(msg);
  setButtonStates(false, true, true, true);
}

// 更新已猜測的數字列表
// 將已猜測的數字顯示在頁面上
function updateGuessedNumbers() {
  $("#guessedNumbers").text($guessedNumbers.join(", "));
}

// 驗證使用者輸入
function validateUserInput(inputValue) {
  const $parsedInput = parseInt(inputValue, 10);

  if (isNaN($parsedInput) || $parsedInput < 1 || $parsedInput > 100) {
    return {
      isValid: false,
      value: null,
      errorMessage: "請輸入 1~100 的整數",
    };
  }

  return {
    isValid: true,
    value: $parsedInput,
    errorMessage: null,
  };
}

// 檢查數字是否已經猜過
function isNumberAlreadyGuessed(number) {
  return $guessedNumbers.includes(number);
}

// 添加猜測數字到列表
function addGuessedNumber(number) {
  if (!isNumberAlreadyGuessed(number)) {
    $guessedNumbers.push(number);
    updateGuessedNumbers();
  }
}

// 處理猜測結果
function processGuessResult(guess) {
  if (guess === $answer) {
    $guessed = true;
    endGame("猜對了！答案是 " + $answer + "。");
  } else if (guess > $answer) {
    updateGameMessage("太大了");
  } else {
    updateGameMessage("太小了");
  }
}

// 處理開始遊戲按鈕點擊
function handleStartGame() {
  resetGame();
}

// 處理提交猜測按鈕點擊
function handleSubmitGuess() {
  if ($guessed || $revealed) return;

  const $inputValue = $("#guess").val();
  const $validationResult = validateUserInput($inputValue);

  if (!$validationResult.isValid) {
    updateGameMessage($validationResult.errorMessage);
    return;
  }

  const $guess = $validationResult.value;
  addGuessedNumber($guess);
  processGuessResult($guess);
}

// 處理顯示答案按鈕點擊
function handleRevealAnswer() {
  if ($answer === null) return;
  $revealed = true;
  endGame("答案是：" + $answer);
}

// 處理 Enter 鍵按下事件
function handleEnterKeyPress(event) {
  if (event.which === 13 && !$("#btnSubmit").prop("disabled")) {
    $("#btnSubmit").click();
  }
}

// 設定初始遊戲狀態
function setInitialGameState() {
  setButtonStates(false, true, true, true);
}

// 綁定所有事件監聽器
function bindEventListeners() {
  $("#btnStart").on("click", handleStartGame);
  $("#btnSubmit").on("click", handleSubmitGuess);
  $("#btnReveal").on("click", handleRevealAnswer);
  $("#guess").on("keypress", handleEnterKeyPress);
}

// 當頁面載入時，初始化遊戲
// 綁定按鈕事件，設置初始狀態
$(function () {
  bindEventListeners();
  setInitialGameState();
});
