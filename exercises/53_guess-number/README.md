# 設計一猜數字程式，由電腦隨機產生一亂數(1~100)讓使用者來猜。每猜一次程式必須回應使用者<答對>、<太大>或<太小>，一直到猜對才結束程式。

## 方式一: 畫面上方提供按鈕 [開始] [公布答案]

- [開始] 點擊後產生一個亂數 (1~100)，讓使用者輸入數字來猜，若 "未猜中" 或 "不知道答案" 之前 [開始] 按鈕不可再按，[公布答案] 按下後顯示本次答案，且不可繼續猜題，提供猜題 [輸入框] 與 [送出] 鈕，送出表單用 PHP 顯示答對、太大或太小，直到猜對為止才再提供[ 開始] 鈕可按。

### 注意: 相關按鈕的 disable 控制，要求需用 PHP 輸出 disable 的屬性 (不是用 JS 修改)

- 想一想: 如何在猜中以前維持題目不變

## 方式二: 改用 JS 寫法，不再送出表單，且顯示每次沒猜中的數字及結果，直到按 [開始] 產生新的一輪遊戲，就把猜題的逐跡紀錄清除，相關按鈕的 disable 控制用 "JQuery" 控制 (不是 Javascript! 請練習 JQuery)
