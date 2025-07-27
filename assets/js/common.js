// 共用 JavaScript 功能模組

/**
 * 防抖函數 - 在指定時間內多次觸發只執行最後一次
 * @param {Function} func 要執行的函數
 * @param {number} delay 延遲時間 (毫秒)
 * @returns {Function} 防抖後的函數
 */
function debounce(func, delay) {
  let timeoutId;
  return function (...args) {
    const context = this;
    clearTimeout(timeoutId);
    timeoutId = setTimeout(() => {
      func.apply(context, args);
    }, delay);
  };
}

/**
 * 節流函數 - 在指定時間內只執行一次
 * @param {Function} func 要執行的函數
 * @param {number} delay 間隔時間 (毫秒)
 * @returns {Function} 節流後的函數
 */
function throttle(func, delay) {
  let lastExecTime = 0;
  return function (...args) {
    const context = this;
    const currentTime = Date.now();
    if (currentTime - lastExecTime >= delay) {
      func.apply(context, args);
      lastExecTime = currentTime;
    }
  };
}

/**
 * 檢查字元是否為大寫英文字母
 * @param {string} char 要檢查的字元
 * @returns {boolean} 是否為大寫英文字母
 */
function isUpperCaseEnglishLetter(char) {
  return /^[A-Z]$/.test(char);
}

/**
 * 檢查字元是否為英文字母
 * @param {string} char 要檢查的字元
 * @returns {boolean} 是否為英文字母
 */
function isEnglishLetter(char) {
  return /^[A-Za-z]$/.test(char);
}

/**
 * 檢查字串是否全部為大寫英文字母
 * @param {string} str 要檢查的字串
 * @returns {boolean} 是否全部為大寫英文字母
 */
function isAllUpperCaseEnglishLetters(str) {
  return /^[A-Z]+$/.test(str);
}

/**
 * 檢查字串是否全部為英文字母
 * @param {string} str 要檢查的字串
 * @returns {boolean} 是否全部為英文字母
 */
function isAllEnglishLetters(str) {
  return /^[A-Za-z]+$/.test(str);
}

/**
 * 分析字串中英文字母的大小寫情況
 * @param {string} str 要分析的字串
 * @returns {object} 分析結果
 */
function analyzeStringCase(str) {
  if (!str) return { valid: false, message: "字串不能為空" };

  const upperCount = (str.match(/[A-Z]/g) || []).length;
  const lowerCount = (str.match(/[a-z]/g) || []).length;
  const nonLetterCount = str.length - upperCount - lowerCount;

  return {
    valid: nonLetterCount === 0,
    totalLength: str.length,
    upperCount: upperCount,
    lowerCount: lowerCount,
    nonLetterCount: nonLetterCount,
    isAllUpper: upperCount === str.length && str.length > 0,
    isAllLower: lowerCount === str.length && str.length > 0,
    isMixed: upperCount > 0 && lowerCount > 0,
    hasNonLetter: nonLetterCount > 0,
  };
}
