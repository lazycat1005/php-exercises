$(document).ready(function () {
  const $form = $("form");
  const $input = $("#subTableInput");
  const $submitButton = $form.find('button[type="submit"]');

  // 前端即時驗證
  $input.on("input", function () {
    const $inputValue = $(this).val().trim();

    // 移除之前的錯誤訊息
    $(".frontendError").remove();

    if ($inputValue === "") {
      return; // 空值不驗證
    }

    const $validationResult = validateInput($inputValue);

    if (!$validationResult.isValid) {
      showFrontendError($validationResult.message);
    }
  });

  // 表單提交前驗證
  $form.on("submit", function (e) {
    const $inputValue = $input.val().trim();

    if ($inputValue === "") {
      return true; // 允許空值提交（顯示預設乘法表）
    }

    const $validationResult = validateInput($inputValue);

    if (!$validationResult.isValid) {
      e.preventDefault();
      showFrontendError($validationResult.message);
      return false;
    }
  });

  // 答案輸入框驗證（當失去焦點時驗證）
  $(document).on("blur", ".answerInput", function () {
    const $answerInput = $(this);
    validateAnswer($answerInput);
  });

  // 答案輸入框輸入驗證（即時驗證格式）
  $(document).on("input", ".answerInput", function () {
    const $answerInput = $(this);
    const $inputValue = $answerInput.val();

    // 移除之前的錯誤狀態
    $answerInput.removeClass("correct incorrect");

    // 檢查輸入格式
    if ($inputValue !== "" && !/^\d+$/.test($inputValue)) {
      $answerInput.addClass("incorrect");
    }
  });

  /**
   * 驗證答案是否正確
   * @param {jQuery} $answerInput 答案輸入框的 jQuery 物件
   */
  function validateAnswer($answerInput) {
    const $userAnswer = $answerInput.val().trim();
    const $correctAnswer = $answerInput.data("correct").toString();

    // 移除之前的樣式
    $answerInput.removeClass("correct incorrect");

    if ($userAnswer === "") {
      return; // 空值不驗證
    }

    // 檢查輸入格式
    if (!/^\d+$/.test($userAnswer)) {
      $answerInput.addClass("incorrect");
      return;
    }

    // 驗證答案正確性
    if ($userAnswer === $correctAnswer) {
      $answerInput.addClass("correct");
    } else {
      $answerInput.addClass("incorrect");
    }
  }

  /**
   * 驗證使用者輸入
   * @param {string} input 使用者輸入
   * @returns {object} 驗證結果 {isValid: boolean, message: string}
   */
  function validateInput(input) {
    // 移除所有空白字元
    const $cleanInput = input.replace(/\s+/g, "");

    // 檢查基本格式：只允許數字、逗號、波浪號
    if (!/^[0-9,~]+$/.test($cleanInput)) {
      return {
        isValid: false,
        message: "輸入格式錯誤，只能包含數字、逗號(,)和波浪號(~)",
      };
    }

    // 分割逗號
    const $parts = $cleanInput.split(",");

    for (let $part of $parts) {
      if ($part === "") {
        return {
          isValid: false,
          message: "輸入格式錯誤，不能有空的部分",
        };
      }

      // 檢查是否為範圍格式
      if ($part.includes("~")) {
        const $rangeResult = validateRange($part);
        if (!$rangeResult.isValid) {
          return $rangeResult;
        }
      } else {
        // 檢查單一數字
        const $numberResult = validateSingleNumber($part);
        if (!$numberResult.isValid) {
          return $numberResult;
        }
      }
    }

    return { isValid: true, message: "" };
  }

  /**
   * 驗證單一數字
   * @param {string} number 數字字串
   * @returns {object} 驗證結果
   */
  function validateSingleNumber(number) {
    // 檢查是否為正整數
    if (!/^\d+$/.test(number)) {
      return {
        isValid: false,
        message: "請輸入正整數",
      };
    }

    const $num = parseInt(number);

    // 檢查範圍 (1-9)
    if ($num < 1 || $num > 9) {
      return {
        isValid: false,
        message: "數字必須在 1-9 範圍內",
      };
    }

    return { isValid: true, message: "" };
  }

  /**
   * 驗證範圍格式
   * @param {string} range 範圍字串
   * @returns {object} 驗證結果
   */
  function validateRange(range) {
    // 檢查波浪號數量
    const $tildeCount = (range.match(/~/g) || []).length;
    if ($tildeCount !== 1) {
      return {
        isValid: false,
        message: "範圍格式錯誤，應該使用單一波浪號(~)分隔",
      };
    }

    // 分割範圍
    const $rangeParts = range.split("~");

    if ($rangeParts.length !== 2) {
      return {
        isValid: false,
        message: "範圍格式錯誤",
      };
    }

    const $start = $rangeParts[0].trim();
    const $end = $rangeParts[1].trim();

    // 檢查起始和結束數字
    const $startResult = validateSingleNumber($start);
    if (!$startResult.isValid) {
      return $startResult;
    }

    const $endResult = validateSingleNumber($end);
    if (!$endResult.isValid) {
      return $endResult;
    }

    const $startNum = parseInt($start);
    const $endNum = parseInt($end);

    // 檢查範圍邏輯
    if ($startNum >= $endNum) {
      return {
        isValid: false,
        message: "範圍的起始數字必須小於結束數字",
      };
    }

    return { isValid: true, message: "" };
  }

  /**
   * 顯示前端錯誤訊息
   * @param {string} message 錯誤訊息
   */
  function showFrontendError(message) {
    // 移除現有的前端錯誤訊息
    $(".frontendError").remove();

    // 創建新的錯誤訊息元素
    const $errorDiv = $('<div class="errorMessage frontendError"></div>');
    $errorDiv.text(message);

    // 插入到輸入框後面
    $input.parent().after($errorDiv);
  }
});
