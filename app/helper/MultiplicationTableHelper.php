<?php
class MultiplicationTableHelper
{
    /**
     * 輸出九九乘法表 HTML
     * @param array $tableNumbers
     * @param int $colsPerRow
     * @param int $rows
     * @param int $tablesPerCell
     * @param bool $withInput (for version-3 interactive)
     * @return string
     */
    public static function renderMultiplicationTable($tableNumbers, $colsPerRow = 3, $rows = 3, $tablesPerCell = 5, $withInput = false)
    {
        $html = '';
        $inputId = 0;
        for ($row = 0; $row < $rows; $row++) {
            $html .= "<tr>";
            for ($col = 0; $col < $colsPerRow; $col++) {
                $html .= "<td>";
                $html .= "<table class='inner'>";
                for ($i = 1; $i <= 9; $i++) {
                    $html .= "<tr>";
                    $baseIndex = $row * $colsPerRow + $col;
                    if (isset($tableNumbers[$baseIndex])) {
                        $base = $tableNumbers[$baseIndex];
                        $result = $base * $i;
                        if ($withInput) {
                            $qid = "q{$inputId}";
                            $html .= "<td>";
                            $html .= "<span class='question' id='label-{$qid}'>{$base} × {$i} = </span>";
                            $html .= "<input type='text' class='answer-input' id='{$qid}' data-ans='{$result}' data-qidx='{$inputId}' autocomplete='off' size='3' disabled>";
                            $html .= "<span class='feedback' id='fb-{$qid}'></span>";
                            $html .= "</td>";
                            $inputId++;
                        } else {
                            $html .= "<td>{$base} × {$i} = {$result}</td>";
                        }
                    } else {
                        $html .= "<td>&nbsp;</td>";
                    }
                    for ($empty = 1; $empty < $tablesPerCell; $empty++) {
                        $html .= "<td>&nbsp;</td>";
                    }
                    $html .= "</tr>";
                }
                $html .= "</table>";
                $html .= "</td>";
            }
            $html .= "</tr>";
        }
        return $html;
    }
}
