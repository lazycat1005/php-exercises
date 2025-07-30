$(function () {
  const $form = $("#constellationForm");
  const $result = $("#result");

  /**
   * 驗證輸入的數字格式是否為正整數
   * @param {string} year - 年份字串
   * @param {string} month - 月份字串
   * @param {string} day - 日期字串
   * @returns {Array} [isValid, errorMessage]
   */
  function validateInputFormat(year, month, day) {
    const pattern = /^(0|[1-9][0-9]*)$/;
    if (!pattern.test(year) || !pattern.test(month) || !pattern.test(day)) {
      return [
        false,
        "請輸入正整數的年、月、日，且不可為負數、浮點數、科學符號或字串",
      ];
    }
    return [true, ""];
  }

  /**
   * 驗證數值是否大於 0
   * @param {number} year - 年份數值
   * @param {number} month - 月份數值
   * @param {number} day - 日期數值
   * @returns {Array} [isValid, errorMessage]
   */
  function validatePositiveNumbers(year, month, day) {
    if (year <= 0 || month <= 0 || day <= 0) {
      return [false, "年、月、日皆需大於 0"];
    }
    return [true, ""];
  }

  /**
   * 驗證日期是否存在
   * @param {number} year - 年份數值
   * @param {number} month - 月份數值
   * @param {number} day - 日期數值
   * @returns {Array} [isValid, errorMessage]
   */
  function validateDateExistence(year, month, day) {
    const date = new Date(year, month - 1, day);
    if (
      date.getFullYear() !== year ||
      date.getMonth() + 1 !== month ||
      date.getDate() !== day
    ) {
      return [false, "請輸入正確存在的日期"];
    }
    return [true, ""];
  }

  /**
   * 綜合驗證生日輸入
   * @param {string} year - 年份字串
   * @param {string} month - 月份字串
   * @param {string} day - 日期字串
   * @returns {Array} [isValid, errorMessage]
   */
  function validateBirthdayInput(year, month, day) {
    // 格式驗證
    const [isFormatValid, formatError] = validateInputFormat(year, month, day);
    if (!isFormatValid) {
      return [false, formatError];
    }

    // 轉換為數值
    const numericYear = parseInt(year, 10);
    const numericMonth = parseInt(month, 10);
    const numericDay = parseInt(day, 10);

    // 正數驗證
    const [isPositiveValid, positiveError] = validatePositiveNumbers(
      numericYear,
      numericMonth,
      numericDay
    );
    if (!isPositiveValid) {
      return [false, positiveError];
    }

    // 日期存在性驗證
    const [isDateValid, dateError] = validateDateExistence(
      numericYear,
      numericMonth,
      numericDay
    );
    if (!isDateValid) {
      return [false, dateError];
    }

    return [true, ""];
  }

  /**
   * 定義星座資料
   * @returns {Array} 星座資料陣列
   */
  function getConstellationData() {
    return [
      { name: "摩羯座", start: [12, 22], end: [1, 19] },
      { name: "水瓶座", start: [1, 20], end: [2, 18] },
      { name: "雙魚座", start: [2, 19], end: [3, 20] },
      { name: "牡羊座", start: [3, 21], end: [4, 19] },
      { name: "金牛座", start: [4, 20], end: [5, 20] },
      { name: "雙子座", start: [5, 21], end: [6, 20] },
      { name: "巨蟹座", start: [6, 21], end: [7, 22] },
      { name: "獅子座", start: [7, 23], end: [8, 22] },
      { name: "處女座", start: [8, 23], end: [9, 22] },
      { name: "天秤座", start: [9, 23], end: [10, 23] },
      { name: "天蠍座", start: [10, 24], end: [11, 22] },
      { name: "射手座", start: [11, 23], end: [12, 21] },
    ];
  }

  /**
   * 檢查日期是否在星座範圍內
   * @param {number} month - 月份
   * @param {number} day - 日期
   * @param {Array} start - 開始日期 [月, 日]
   * @param {Array} end - 結束日期 [月, 日]
   * @returns {boolean} 是否在範圍內
   */
  function isDateInRange(month, day, start, end) {
    const [startMonth, startDay] = start;
    const [endMonth, endDay] = end;

    if (startMonth > endMonth) {
      // 跨年的情況（如摩羯座 12/22 - 1/19）
      return (
        (month === startMonth && day >= startDay) ||
        (month === endMonth && day <= endDay)
      );
    } else {
      // 一般情況
      return (
        (month === startMonth && day >= startDay) ||
        (month === endMonth && day <= endDay)
      );
    }
  }

  /**
   * 根據月日取得星座
   * @param {number} month - 月份
   * @param {number} day - 日期
   * @returns {string} 星座名稱
   */
  function getConstellation(month, day) {
    const constellations = getConstellationData();

    for (const constellation of constellations) {
      if (isDateInRange(month, day, constellation.start, constellation.end)) {
        return constellation.name;
      }
    }
    return "未知";
  }

  /**
   * 定義生肖資料
   * @returns {Array} 生肖陣列
   */
  function getZodiacData() {
    return [
      "鼠",
      "牛",
      "虎",
      "兔",
      "龍",
      "蛇",
      "馬",
      "羊",
      "猴",
      "雞",
      "狗",
      "豬",
    ];
  }

  /**
   * 將民國年轉換為西元年
   * @param {string} year - 年份字串
   * @param {string} eraType - 紀元類型
   * @returns {number} 西元年
   */
  function convertToWesternYear(year, eraType) {
    if (eraType === "民國") {
      return parseInt(year, 10) + 1911;
    }
    return parseInt(year, 10);
  }

  /**
   * 根據年份取得生肖
   * @param {string} year - 年份字串
   * @param {string} eraType - 紀元類型
   * @returns {string} 生肖名稱
   */
  function getZodiac(year, eraType) {
    const westernYear = convertToWesternYear(year, eraType);
    const zodiacs = getZodiacData();
    let index = (westernYear - 1900) % 12;
    if (index < 0) index += 12;
    return zodiacs[index];
  }

  /**
   * 計算年齡
   * @param {number} birthYear - 出生年份
   * @param {number} birthMonth - 出生月份
   * @param {number} birthDay - 出生日期
   * @returns {number} 年齡
   */
  function calculateAge(birthYear, birthMonth, birthDay) {
    const today = new Date();
    const birthDate = new Date(birthYear, birthMonth - 1, birthDay);
    let age = today.getFullYear() - birthDate.getFullYear();
    if (
      today.getMonth() < birthDate.getMonth() ||
      (today.getMonth() === birthDate.getMonth() &&
        today.getDate() < birthDate.getDate())
    ) {
      age--;
    }
    return age;
  }

  /**
   * 取得表單輸入值
   * @returns {Object} 包含所有表單值的物件
   */
  function getFormInputs() {
    return {
      eraType: $("#eraType").val(),
      year: $("#birthYear").val().trim(),
      month: $("#birthMonth").val().trim(),
      day: $("#birthDay").val().trim(),
    };
  }

  /**
   * 顯示錯誤訊息
   * @param {string} errorMessage - 錯誤訊息
   */
  function displayError(errorMessage) {
    $result.html(`<p class='error'>錯誤: ${errorMessage}</p>`);
  }

  /**
   * 顯示結果
   * @param {Object} data - 包含年、月、日、紀元、年齡、星座、生肖的資料
   */
  function displayResult(data) {
    $result.html(`
            <p>您的生日是: <strong>${data.year} 年 ${data.month} 月 ${data.day} 日</strong>（${data.eraType}）</p>
            <p>您的實際年齡是: <strong>${data.age} 歲</strong></p>
            <p>您的星座是: <strong>${data.constellation}</strong></p>
            <p>您的生肖是: <strong>${data.zodiac}</strong></p>
        `);
  }

  /**
   * 處理表單提交
   * @param {Event} e - 事件物件
   */
  function handleFormSubmit(e) {
    e.preventDefault();
    $result.empty();

    const inputs = getFormInputs();
    const { eraType, year, month, day } = inputs;

    // 民國轉西元驗證
    let checkYear = year;
    if (eraType === "民國") {
      checkYear = parseInt(year, 10) + 1911;
    }

    const [isValid, errorMessage] = validateBirthdayInput(
      checkYear,
      month,
      day
    );

    if (!isValid) {
      displayError(errorMessage);
      return;
    }

    const constellation = getConstellation(Number(month), Number(day));
    const zodiac = getZodiac(year, eraType);
    const age = calculateAge(Number(checkYear), Number(month), Number(day));

    displayResult({
      year: year,
      month: month,
      day: day,
      eraType: eraType,
      age: age,
      constellation: constellation,
      zodiac: zodiac,
    });
  }

  // 綁定表單提交事件
  $form.on("submit", handleFormSubmit);
});
