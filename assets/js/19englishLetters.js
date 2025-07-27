// 19 英文字母大小寫驗證 - 支援字串驗證
$(function () {
  // 工具函式：取得 allowLower 屬性
  const getAllowLower = ($el) =>
    $el.data("allow-lower") === true || $el.data("allow-lower") === "true";

  // 工具函式：顯示驗證訊息
  const $showValidationMessage = debounce((message, isError = true) => {
    const $charInput = $("#charInput");
    let $errorMsg = $("#char-error-msg");
    if ($errorMsg.length === 0) {
      $errorMsg = $('<div id="char-error-msg" class="error-message"></div>');
      $charInput.after($errorMsg);
    }
    $charInput.toggleClass("error", isError);
    $errorMsg
      .removeClass("success error")
      .addClass(isError ? "error" : "success")
      .text(message)
      .show();
    setTimeout(() => {
      $charInput.removeClass("error");
      $errorMsg.hide();
    }, 3000);
  }, 300);

  // 工具函式：清理非英文字母
  const cleanEnglishLetters = (str) => str.replace(/[^A-Za-z]/g, "");
  // 工具函式：移除小寫字母
  const removeLowerCase = (str) => str.replace(/[a-z]/g, "");

  // 驗證字串並顯示訊息
  const $validateStringInput = debounce((str) => {
    if (!str) return;
    const allowLower = getAllowLower($("#charInput"));
    const analysis = analyzeStringCase(str);
    if (!analysis.valid) {
      $showValidationMessage(
        `輸入包含 ${analysis.nonLetterCount} 個非英文字母字元`,
        true
      );
      return;
    }
    if (!allowLower && analysis.lowerCount > 0) {
      $showValidationMessage(
        `包含 ${analysis.lowerCount} 個小寫字母，請全部使用大寫`,
        true
      );
      return;
    }
    let message = `字串長度: ${analysis.totalLength}, `;
    if (analysis.isAllUpper) message += "全部為大寫字母";
    else if (analysis.isAllLower) message += "全部為小寫字母";
    else if (analysis.isMixed)
      message += `大寫: ${analysis.upperCount}, 小寫: ${analysis.lowerCount}`;
    $showValidationMessage(message, false);
  }, 500);

  // 處理 keypress 事件（限制非英文字母輸入）
  const handleKeyPress = (e) => {
    const char = String.fromCharCode(e.which || e.keyCode);
    if (!isEnglishLetter(char)) {
      e.preventDefault();
      $showValidationMessage("只能輸入英文字母", true);
    }
  };

  // 處理貼上事件
  const handlePaste = (e) => {
    e.preventDefault();
    const $input = $(e.target);
    const allowLower = getAllowLower($input);
    const clipboardData = e.originalEvent.clipboardData || window.clipboardData;
    const pastedText = clipboardData.getData("text");
    if (!pastedText) return;
    const analysis = analyzeStringCase(pastedText);
    if (!analysis.valid) {
      $showValidationMessage(
        `貼上的內容包含 ${analysis.nonLetterCount} 個非英文字母字元，已拒絕貼上`,
        true
      );
      return;
    }
    if (!allowLower && analysis.lowerCount > 0) {
      $showValidationMessage(
        `貼上的內容包含 ${analysis.lowerCount} 個小寫字母，請使用大寫字母`,
        true
      );
      return;
    }
    $input.val(pastedText);
    $validateStringInput(pastedText);
  };

  // 處理 input 事件
  const handleInput = (e) => {
    const $input = $(e.target);
    const value = $input.val();
    const allowLower = getAllowLower($input);
    if (value.length > 0) {
      const cleanValue = cleanEnglishLetters(value);
      if (cleanValue !== value) {
        $input.val(cleanValue);
        $showValidationMessage("已移除非英文字母字元", true);
        return;
      }
      if (!allowLower) {
        const analysis = analyzeStringCase(cleanValue);
        if (analysis.lowerCount > 0) {
          const upperOnlyValue = removeLowerCase(cleanValue);
          $input.val(upperOnlyValue);
          $showValidationMessage("不允許輸入小寫字母，已移除小寫字母", true);
          return;
        }
      }
      $validateStringInput(cleanValue);
    }
  };

  // 處理 blur 事件
  const handleBlur = (e) => {
    $(e.target).removeClass("error");
    $("#char-error-msg").hide();
  };

  // 禁用右鍵選單
  const handleContextMenu = (e) => {
    e.preventDefault();
    $showValidationMessage("不允許使用右鍵選單", true);
  };

  // 禁用拖拽
  const handleDrop = (e) => {
    e.preventDefault();
    $showValidationMessage("不允許拖拽輸入", true);
  };

  // 處理快捷鍵
  const handleKeyDown = (e) => {
    if (e.ctrlKey && e.which === 86) {
      const allowLower = getAllowLower($(e.target));
      if (!allowLower) {
        e.preventDefault();
        $showValidationMessage("請使用手動輸入，不允許貼上", true);
      }
    }
  };

  // 綁定事件
  const $charInput = $("#charInput");
  $charInput.on("keypress", handleKeyPress);
  $charInput.on("paste", handlePaste);
  $charInput.on("input", handleInput);
  $charInput.on("blur", handleBlur);
  $charInput.on("contextmenu", handleContextMenu);
  $charInput.on("drop", handleDrop);
  $charInput.on("keydown", handleKeyDown);
});
