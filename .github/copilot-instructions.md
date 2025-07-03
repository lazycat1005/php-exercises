# 專案介紹

此專案是用於練習 php 7.3 與 jQuery 1.12.4 的練習題專案。

利用創建子資料夾的方式，將不同練習題目區隔開，每個題目都會有多個版本 (子資料夾)，並且會有一個 `README.md` 檔案來說明題目的內容。

另外也會將重複的程式碼抽出來，練習模組化與物件化。

## 代碼風格

### PHP

- 請遵循 PSR-12 代碼風格指南，並且使用空格來縮排程式碼。

### jQuery (JavaScript)

- 此專案使用 jQuery 1.12.4 版本。

- 撰寫 jQuery 程式碼時，請遵循 JavaScript ES2015+ 語法，不要再使用 var 來定義變數。

### scss (css)

- 若要新增 css 樣式，請使用 SCSS 語法，並放置在相對應的檔案結構中，可以參考 [spec.md](spec.md) 中的目錄結構規劃。

- 撰寫 SCSS 時，請注意在 `all.css` 檔案中已經使用 `html {font-size: 62.5%;}`，因此在使用 rem 單位時，1rem = 10px，預設字體 16px 會變成 1.6rem 才對，否則 1rem 的字體會變顯得過小，不容易閱讀。

- 字體大小與間距請使用 `rem` 單位，但是陰影與圓角請使用 `px` 單位。

- `.fixedBtn` 樣式已經寫入 `all.css` 檔案中，請不用針對這個 class 做任何修改。

## 生成紀錄

- 每日創建一個新的 `log.md` 檔案於 [historyLog](.github/historyLog) 資料夾中，並在檔案命稱後面加上日期，檔案名稱範例為：`log_2025-07-01.md`，若檔案已存在則不要覆蓋，僅需寫入。

- 每次請求修改後將修改紀錄寫進 `log.md` 檔案中，讓下一位繼任者了解你修改了什麼，好方便接續的工作。

## 注意事項

- 所有使用者的資料輸入皆需要嚴謹的前後端驗證流程，以防止惡意攻擊或注入攻擊等情況。

- 生成 git commit 時，請參考 [.copilot-commit-message-instructions.md](.github/.copilot-commit-message-instructions.md) 中的指示，並且使用中文。
