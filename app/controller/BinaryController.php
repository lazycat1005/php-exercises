<?php

namespace App\Controller;

use App\Validator\BinaryValidator;

class BinaryController
{
    private $validator;

    public function __construct()
    {
        $this->validator = new BinaryValidator();
    }

    /**
     * 進位遞迴除法步驟（版本1）
     * @param int|string $input
     * @return array [success, message, steps, remainders, onesCount]
     */
    public function getBinaryStepsInfo($input)
    {
        $validation = $this->validator->validateInput($input);
        if ($validation !== true) {
            return [
                'success' => false,
                'message' => $validation
            ];
        }
        $num = intval($input);
        $steps = [];
        while ($num > 0) {
            $quotient = intdiv($num, 2);
            $remainder = $num % 2;
            $steps[] = [
                'value' => $num,
                'quotient' => $quotient,
                'remainder' => $remainder
            ];
            $num = $quotient;
        }
        $remainders = array_column($steps, 'remainder');
        $onesCount = 0;
        foreach ($remainders as $r) {
            if ($r === 1) {
                $onesCount++;
            }
        }
        return [
            'success' => true,
            'steps' => $steps,
            'remainders' => $remainders,
            'onesCount' => $onesCount
        ];
    }

    /**
     * 字串切割法（版本2）
     * @param int|string $input
     * @return array [success, message, binaryStr, digits, onesCount]
     */
    public function getBinaryStringInfo($input)
    {
        $validation = $this->validator->validateInput($input);
        if ($validation !== true) {
            return [
                'success' => false,
                'message' => $validation
            ];
        }
        $num = intval($input);
        $binaryStr = decbin($num);
        $digits = str_split($binaryStr);
        $onesCount = 0;
        foreach ($digits as $d) {
            if ($d === '1') {
                $onesCount++;
            }
        }
        return [
            'success' => true,
            'binaryStr' => $binaryStr,
            'digits' => $digits,
            'onesCount' => $onesCount
        ];
    }
}
