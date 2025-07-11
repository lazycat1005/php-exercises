<?php

namespace App\Controller;

class ReceiptPrizeCheckerController
{
    /**
     * @var string
     */
    private $specialPrize1;
    /**
     * @var string
     */
    private $specialPrize2;
    /**
     * @var array
     */
    private $firstPrizes;

    public function __construct($specialPrize1, $specialPrize2, array $firstPrizes)
    {
        $this->specialPrize1 = $specialPrize1;
        $this->specialPrize2 = $specialPrize2;
        $this->firstPrizes = $firstPrizes;
    }

    /**
     * 對獎邏輯
     * @param string $receipt
     * @return string
     */
    public function checkReceipt($receipt)
    {
        // 若剛好是 8 碼，可比對特等獎與特獎
        if (strlen($receipt) === 8) {
            if ($receipt === $this->specialPrize1) {
                return '特等獎1000萬';
            }
            if ($receipt === $this->specialPrize2) {
                return '特獎200萬';
            }
        }

        // 比對頭獎
        $awardLevels = [
            8 => '頭獎20萬',
            7 => '末7碼中4萬',
            6 => '末6碼中1萬',
            5 => '末5碼中4000',
            4 => '末4碼中1000',
            3 => '末3碼中200',
        ];

        foreach ($this->firstPrizes as $prize) {
            for ($len = 8; $len >= 3; $len--) {
                if (strlen($receipt) >= $len) {
                    $userTail = substr($receipt, -$len);
                    $prizeTail = substr($prize, -$len);
                    if ($userTail === $prizeTail) {
                        return $awardLevels[$len];
                    }
                }
            }
        }
        return '沒中獎。';
    }
}
