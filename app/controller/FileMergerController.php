<?php

namespace App\Controller;

use App\Validator\FileMergerValidator;

class FileMergerController
{
    private $validator;

    public function __construct()
    {
        $this->validator = new FileMergerValidator();
    }

    /**
     * 合併兩個上傳檔案
     * @param array $file1
     * @param array $file2
     * @return array [success, html]
     */
    public function mergeFiles($file1, $file2)
    {
        $error = $this->validator->validateFiles($file1, $file2);
        if ($error) {
            return [
                'success' => false,
                'html' => "<div class='file-merger__result file-merger__result--error'><p>{$error}</p></div>"
            ];
        }
        $content1 = file_get_contents($file1['tmp_name']);
        $content2 = file_get_contents($file2['tmp_name']);
        $mergedContent = $content1 . "\n" . $content2;
        $mergedFileName = 'merged_file.txt';
        file_put_contents($mergedFileName, $mergedContent);
        $html = "<div class='file-merger__result file-merger__result--success'><p>檔案合併成功！<a href='$mergedFileName' download>點此下載合併後的檔案</a></p></div>";
        return [
            'success' => true,
            'html' => $html
        ];
    }
}
