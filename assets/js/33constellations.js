$(function () {
  const $form = $("#constellation-form");
  const $result = $("#result");

  function validateBirthdayInput(year, month, day) {
    const pattern = /^(0|[1-9][0-9]*)$/;
    if (!pattern.test(year) || !pattern.test(month) || !pattern.test(day)) {
      return [
        false,
        "請輸入正整數的年、月、日，且不可為負數、浮點數、科學符號或字串",
      ];
    }
    year = parseInt(year, 10);
    month = parseInt(month, 10);
    day = parseInt(day, 10);
    if (year <= 0 || month <= 0 || day <= 0) {
      return [false, "年、月、日皆需大於 0"];
    }
    // 檢查日期是否存在
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

  function getConstellation(month, day) {
    const constellations = [
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
    for (const c of constellations) {
      const [startMonth, startDay] = c.start;
      const [endMonth, endDay] = c.end;
      if (
        (month === startMonth && day >= startDay) ||
        (month === endMonth && day <= endDay) ||
        (startMonth > endMonth &&
          ((month === startMonth && day >= startDay) ||
            (month === endMonth && day <= endDay)))
      ) {
        return c.name;
      }
    }
    return "未知";
  }

  function getZodiac(year, eraType) {
    if (eraType === "民國") {
      year = parseInt(year, 10) + 1911;
    } else {
      year = parseInt(year, 10);
    }
    const zodiacs = [
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
    let index = (year - 1900) % 12;
    if (index < 0) index += 12;
    return zodiacs[index];
  }

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

  $form.on("submit", function (e) {
    e.preventDefault();
    $result.empty();
    const eraType = $("#eraType").val();
    let year = $("#birthYear").val().trim();
    const month = $("#birthMonth").val().trim();
    const day = $("#birthDay").val().trim();

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
      $result.html(`<p class='error'>錯誤: ${errorMessage}</p>`);
      return;
    }
    const constellation = getConstellation(Number(month), Number(day));
    const zodiac = getZodiac(year, eraType);
    const age = calculateAge(Number(checkYear), Number(month), Number(day));
    $result.html(`
            <p>您的生日是: <strong>${year} 年 ${month} 月 ${day} 日</strong>（${eraType}）</p>
            <p>您的實際年齡是: <strong>${age} 歲</strong></p>
            <p>您的星座是: <strong>${constellation}</strong></p>
            <p>您的生肖是: <strong>${zodiac}</strong></p>
        `);
  });
});
