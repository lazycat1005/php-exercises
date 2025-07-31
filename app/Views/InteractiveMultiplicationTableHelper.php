<?php

namespace App\Views;

class InteractiveMultiplicationTableHelper
{
    /**
     * 渲染完整的互動式九九乘法表
     * 
     * @param array $tableData 從控制器傳來的乘法表資料
     * @return string 回傳 HTML 字串
     */
    public static function renderMultiplicationTable(array $tableData): string
    {
        $html = '<table>' . PHP_EOL;
        $html .= '    <tbody>' . PHP_EOL;

        foreach ($tableData as $rowData) {
            $html .= '        <tr>' . PHP_EOL;
            foreach ($rowData as $colData) {
                $html .= '            <td>' . PHP_EOL;
                $html .= self::renderSingleTable($colData);
                $html .= '            </td>' . PHP_EOL;
            }
            $html .= '        </tr>' . PHP_EOL;
        }

        $html .= '    </tbody>' . PHP_EOL;
        $html .= '</table>' . PHP_EOL;

        return $html;
    }

    /**
     * 渲染單一互動式乘法表
     * 
     * @param array $singleTableData 單一乘法表的資料
     * @return string 回傳 HTML 字串
     */
    private static function renderSingleTable(array $singleTableData): string
    {
        $html = '                <table>' . PHP_EOL;
        $html .= '                    <tbody>' . PHP_EOL;

        foreach ($singleTableData['rows'] as $index => $row) {
            $inputId = 'answer_' . $row['multiplier'] . '_' . $row['multiplicand'];
            $correctAnswer = $row['result'];

            $html .= '                        <tr>' . PHP_EOL;
            $html .= '                            <td>' . htmlspecialchars($row['multiplier']) . '</td>' . PHP_EOL;
            $html .= '                            <td>*</td>' . PHP_EOL;
            $html .= '                            <td>' . htmlspecialchars($row['multiplicand']) . '</td>' . PHP_EOL;
            $html .= '                            <td>=</td>' . PHP_EOL;
            $html .= '                            <td>' . PHP_EOL;
            $html .= '                                <input type="number" ' . PHP_EOL;
            $html .= '                                       id="' . $inputId . '" ' . PHP_EOL;
            $html .= '                                       class="answerInput" ' . PHP_EOL;
            $html .= '                                       data-correct="' . $correctAnswer . '" ' . PHP_EOL;
            $html .= '                                       placeholder="?" ' . PHP_EOL;
            $html .= '                                       min="0" ' . PHP_EOL;
            $html .= '                                       step="1">' . PHP_EOL;
            $html .= '                            </td>' . PHP_EOL;
            $html .= '                        </tr>' . PHP_EOL;
        }

        $html .= '                    </tbody>' . PHP_EOL;
        $html .= '                </table>' . PHP_EOL;

        return $html;
    }
}
