<?php

namespace App\Controller;

use App\Validator\ReceiptPrizeCheckerValidator;

class ReceiptPrizeCheckerController
{
    // 取得中獎規則
    public static function getPrizeRules()
    {
        return [
            'special' => [ // 特別獎：1000萬（8碼全中）
                'label' => '特別獎',
                'amount' => 10000000,
                'numbers' => ['64557267'], // 實際中獎號碼
            ],
            'grand' => [ // 特獎：200萬（8碼全中）
                'label' => '特獎',
                'amount' => 2000000,
                'numbers' => ['64808075'], // 實際中獎號碼
            ],
            'first' => [ // 頭獎：8碼全中
                'label' => '頭獎',
                'amount' => 200000,
                'numbers' => ['04322277', '07903676', '98883497'],
            ],
            'matching' => [ // 對中幾碼的對應獎金（僅適用於頭獎落空但對到後面幾碼）
                7 => ['label' => '貳獎', 'amount' => 40000],
                6 => ['label' => '參獎', 'amount' => 10000],
                5 => ['label' => '肆獎', 'amount' => 4000],
                4 => ['label' => '伍獎', 'amount' => 1000],
                3 => ['label' => '陸獎', 'amount' => 200],
            ],
        ];
    }

    // 取得使用者輸入的發票號碼
    public static function checkPrize($invoiceNumber, $rules)
    {
        // 特別獎
        foreach ($rules['special']['numbers'] as $num) {
            if ($invoiceNumber === $num) {
                return $rules['special'];
            }
        }

        // 特獎
        foreach ($rules['grand']['numbers'] as $num) {
            if ($invoiceNumber === $num) {
                return $rules['grand'];
            }
        }

        // 頭獎（及其尾數）
        foreach ($rules['first']['numbers'] as $num) {
            if ($invoiceNumber === $num) {
                return $rules['first'];
            }

            // 對後幾碼
            for ($i = 7; $i >= 3; $i--) {
                if (substr($invoiceNumber, -$i) === substr($num, -$i)) {
                    return $rules['matching'][$i];
                }
            }
        }

        return ['label' => '未中獎', 'amount' => 0];
    }

    //處理表單提交並將每一筆查詢紀錄在session中
    public static function handleFormSubmission()
    {
        if (!isset($_GET['receipt'])) {
            return;
        }

        $receipt = trim($_GET['receipt']);
        $rules = self::getPrizeRules();

        if (!ReceiptPrizeCheckerValidator::validateReceipt($receipt)) {
            $result = [
                'number' => $receipt,
                'label' => '格式錯誤',
                'amount' => 0,
                'msg' => '請輸入3~8位數字，不可有字母或符號'
            ];
        } else {
            $prize = self::checkPrize($receipt, $rules);
            $result = [
                'number' => $receipt,
                'label' => $prize['label'],
                'amount' => $prize['amount'],
                'msg' => $prize['amount'] > 0 ? "恭喜中獎！" : "很遺憾，未中獎"
            ];
        }

        // 記錄到 session
        $_SESSION['results'][] = $result;

        // PRG：轉址移除 GET 參數，避免重整重複送出
        header('Location: ' . strtok($_SERVER['REQUEST_URI'], '?'));
        exit;
    }
}
