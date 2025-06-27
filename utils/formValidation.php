<?php

//建立一個類別，用於驗證表單的輸入是否為純數字，不包含科學記號
class FormValidation
{
  // 檢查輸入是否為純數字
  public static function isValidNumber($input)
  {
    // 檢查是否為數字且不包含科學記號
    return is_numeric($input) && !preg_match('/e/i', $input);
  }

  // 檢查輸入是否為正整數
  public static function isPositiveInteger($input)
  {
    return self::isValidNumber($input) && $input >= 0 && floor($input) == $input;
  }
}
