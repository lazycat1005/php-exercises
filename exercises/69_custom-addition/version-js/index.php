<?php
require_once '../../../vendor/autoload.php';

use App\Helper\HtmlHelper;

HtmlHelper::renderHeader('customAddition', '');
?>

<main>
    <header>
        <h1>自訂加法</h1>
        <p> 用 JS 自己寫浮點數的"加法" (乘法不用)，將浮點數換為整數計算後，再補回小數點(可對照印出 JS 的 .toFixed 的結果比對是否一致)</p>
    </header>

    <form id="additionForm">
        <label for="number1">第一個數字：</label>
        <input type="number" id="number1" name="number1" required step="any">

        <label for="number2">第二個數字：</label>
        <input type="number" id="number2" name="number2" required step="any">

        <button type="submit">計算和</button>
    </form>

    <div id="result"></div>

</main>

<script>
    //寫一個驗證使用者輸入的函數，驗證使用者所輸入的兩個資料只能是數字或浮點數，不能為字元或含有科學符號(如:1e2)
    function validateInput(input1, input2) {
        const regex = /^-?\d+(\.\d+)?$/;
        if (!regex.test(input1) || !regex.test(input2)) {
            return false;
        }
        return true;
    }
    //將經validateInput()驗證過後的兩個數字轉為字串並分析每個數字的小數位數
    function convertToString(input1, input2) {
        const str1 = input1.toString();
        const str2 = input2.toString();

        const decimalPlaces1 = str1.includes('.') ? str1.split('.')[1].length : 0; //如果帶入12345則結果為 0
        const decimalPlaces2 = str2.includes('.') ? str2.split('.')[1].length : 0; //如果帶入0.1則結果為 1

        return [str1, str2, decimalPlaces1, decimalPlaces2];
    }
    //比較$decimalPlaces1和$decimalPlaces2的位數，找出最大位數n，並將$input1和$input2各自乘以10^n
    function adjustForDecimalPlaces(str1, str2, decimalPlaces1, decimalPlaces2) {
        const maxDecimalPlaces = Math.max(decimalPlaces1, decimalPlaces2);

        const adjusted1 = parseInt(str1.replace('.', '').padEnd(maxDecimalPlaces + str1.length - str1.indexOf('.') - 1, '0'));
        const adjusted2 = parseInt(str2.replace('.', '').padEnd(maxDecimalPlaces + str2.length - str2.indexOf('.') - 1, '0'));

        return [adjusted1, adjusted2, maxDecimalPlaces];
    }

    // 將計算的結果與JS的 .toFixed() 函數的結果進行"==="比對，並輸出true或false
    function compareWithToFixed(originalStr1, originalStr2, adjusted1, adjusted2, maxDecimalPlaces) {
        const toFixedResult = (parseFloat(originalStr1) + parseFloat(originalStr2)).toFixed(maxDecimalPlaces);
        const calculatedResult = calculateSum(adjusted1, adjusted2, maxDecimalPlaces);
        return toFixedResult === calculatedResult ? 'true' : 'false';
    }

    //計算兩個整數的和，然後將結果除以10^n，並將小數點補回去
    function calculateSum(adjusted1, adjusted2, maxDecimalPlaces) {
        const sum = adjusted1 + adjusted2;
        const result = sum / Math.pow(10, maxDecimalPlaces); //如果$sun是"12345"和"10"的和，則結果為"12355"，然後除以10^2(即100)，結果為"123.55"
        return result.toFixed(maxDecimalPlaces);
    }

    // 處理表單提交
    document.getElementById('additionForm').addEventListener('submit', function(event) {
        event.preventDefault(); // 防止表單提交

        const number1Raw = document.getElementById('number1').value;
        const number2Raw = document.getElementById('number2').value;

        if (validateInput(number1Raw, number2Raw)) {
            const number1 = parseFloat(number1Raw);
            const number2 = parseFloat(number2Raw);
            const [str1, str2, decimalPlaces1, decimalPlaces2] = convertToString(number1, number2);
            const [adjusted1, adjusted2, maxDecimalPlaces] = adjustForDecimalPlaces(str1, str2, decimalPlaces1, decimalPlaces2);
            const result = calculateSum(adjusted1, adjusted2, maxDecimalPlaces);
            const comparisonResult = compareWithToFixed(str1, str2, adjusted1, adjusted2, maxDecimalPlaces);

            document.getElementById('result').innerHTML = `
            <p>計算結果: ${result}</p>
            <p>與 JS 的 .toFixed() 函數結果比對: ${comparisonResult}</p>
        `;
        } else {
            document.getElementById('result').innerHTML = '<p>請輸入有效的數字。</p>';
        }
    });
</script>



<?php HtmlHelper::renderFooter(); ?>