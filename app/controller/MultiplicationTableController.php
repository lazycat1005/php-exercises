<?php

namespace App\Controller;

use App\Validator\MultiplicationTableValidator;

class MultiplicationTableController extends BaseController
{
    private $validator;
    private $errorMessage = '';
    private $userInput = '';

    public function __construct()
    {
        $this->validator = new MultiplicationTableValidator();
    }

    /**
     * 生成九九乘法表的資料結構（預設版本）
     * 
     * @return array 包含九九乘法表資料的三維陣列
     */
    public function generateMultiplicationTableData(): array
    {
        $tableData = [];

        // 建立 3x3 的大表格結構
        for ($row = 0; $row < 3; $row++) {
            $tableData[$row] = [];
            for ($col = 0; $col < 3; $col++) {
                $multiplier = $row * 3 + $col + 1;
                $tableData[$row][$col] = $this->generateSingleTableData($multiplier);
            }
        }

        return $tableData;
    }

    /**
     * 根據指定的數字陣列生成乘法表資料
     * 
     * @param array $numbers 要生成乘法表的數字陣列
     * @return array 包含乘法表資料的陣列
     */
    public function generateCustomMultiplicationTableData(array $numbers): array
    {
        $tableData = [];
        $numbersPerRow = 3; // 每行顯示3個乘法表
        $totalNumbers = count($numbers);

        // 計算需要多少行
        $rows = ceil($totalNumbers / $numbersPerRow);

        for ($row = 0; $row < $rows; $row++) {
            $tableData[$row] = [];
            for ($col = 0; $col < $numbersPerRow; $col++) {
                $index = $row * $numbersPerRow + $col;
                if ($index < $totalNumbers) {
                    $multiplier = $numbers[$index];
                    $tableData[$row][$col] = $this->generateSingleTableData($multiplier);
                }
            }
        }

        return $tableData;
    }

    /**
     * 生成單一乘法表的資料
     * 
     * @param int $multiplier 被乘數
     * @return array 包含單一乘法表的資料陣列
     */
    private function generateSingleTableData(int $multiplier): array
    {
        $singleTableData = [];
        $singleTableData['multiplier'] = $multiplier;
        $singleTableData['rows'] = [];

        for ($i = 1; $i <= 9; $i++) {
            $singleTableData['rows'][] = [
                'multiplier' => $multiplier,
                'multiplicand' => $i,
                'result' => $multiplier * $i
            ];
        }

        return $singleTableData;
    }

    /**
     * 處理九九乘法表頁面的主要邏輯
     * 
     * @return array 回傳給視圖的資料
     */
    public function index(): array
    {
        // 處理 GET 請求
        $this->handleRequest();

        // 只有在使用者輸入且驗證通過時，才生成自訂乘法表
        if (!empty($this->userInput) && empty($this->errorMessage)) {
            try {
                $numbers = $this->validator->parseInput($this->userInput);
                return $this->generateCustomMultiplicationTableData($numbers);
            } catch (\Exception $e) {
                $this->errorMessage = $e->getMessage();
            }
        }

        // 沒有有效輸入或驗證失敗時，回傳空陣列（不顯示表格）
        return [];
    }

    /**
     * 處理 version-1 的邏輯（預設顯示完整九九乘法表）
     * 
     * @return array 回傳給視圖的資料
     */
    public function indexWithDefault(): array
    {
        // 處理 GET 請求
        $this->handleRequest();

        // 如果使用者有輸入且驗證通過，生成自訂乘法表
        if (!empty($this->userInput) && empty($this->errorMessage)) {
            try {
                $numbers = $this->validator->parseInput($this->userInput);
                return $this->generateCustomMultiplicationTableData($numbers);
            } catch (\Exception $e) {
                $this->errorMessage = $e->getMessage();
            }
        }

        // 預設顯示完整九九乘法表
        return $this->generateMultiplicationTableData();
    }

    /**
     * 取得錯誤訊息
     * 
     * @return string 錯誤訊息
     */
    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

    /**
     * 取得使用者輸入
     * 
     * @return string 使用者輸入
     */
    public function getUserInput(): string
    {
        return $this->userInput;
    }

    /**
     * 實作基底控制器必需的方法
     */
    public function handleRequest(): void
    {
        if (isset($_GET['subTableInput'])) {
            $this->userInput = trim($_GET['subTableInput']);

            if (!empty($this->userInput)) {
                try {
                    $this->validator->validate($this->userInput);
                } catch (\InvalidArgumentException $e) {
                    $this->errorMessage = $e->getMessage();
                }
            }
        }
    }
}
