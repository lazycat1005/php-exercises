<?php
class FileMergerValidator
{
    /**
     * 驗證兩個檔案是否為純txt
     * @param array $file1
     * @param array $file2
     * @return string|null 錯誤訊息或 null
     */
    public function validateFiles($file1, $file2)
    {
        if (!isset($file1['tmp_name'], $file2['tmp_name'])) {
            return '請選擇兩個檔案進行合併。';
        }
        if ($file1['type'] !== 'text/plain' || $file2['type'] !== 'text/plain') {
            return '請上傳純文字檔案（.txt）！';
        }
        if (!is_uploaded_file($file1['tmp_name']) || !is_uploaded_file($file2['tmp_name'])) {
            return '檔案上傳錯誤，請重新嘗試。';
        }
        // 防止偽造副檔名，檢查內容是否為純文字
        $content1 = file_get_contents($file1['tmp_name']);
        $content2 = file_get_contents($file2['tmp_name']);
        if (!mb_check_encoding($content1, 'UTF-8') || !mb_check_encoding($content2, 'UTF-8')) {
            return '檔案內容非有效純文字，請檢查檔案來源。';
        }
        return null;
    }
}
