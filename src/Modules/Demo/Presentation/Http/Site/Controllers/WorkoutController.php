<?php

namespace Untek\Sandbox\Module\Modules\Demo\Presentation\Http\Site\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Untek\Component\Text\Helpers\TextHelper;
use Untek\Sandbox\Module\Presentation\Http\Site\Controllers\AbstractSandboxController;

// http://taxi.fk/sandbox/demo/workout

class WorkoutController extends AbstractSandboxController
{

    public function __invoke(Request $request): Response
    {
        $twoDumbbellWeight = [
            5,
            2.5,
            2.5,
            1.25,
            0.5,
        ];
        $twoDumbbellData = $this->generateTable($twoDumbbellWeight, 1.5, 5);
        $twoDumbbellHtml = $this->renderTable($twoDumbbellData);

        $oneDumbbellWeight = [
            5,
            5,
            2.5,
            2.5,
            2.5,
            2.5,
            1.25,
            1.25,
            0.5,
        ];
        $oneDumbbellData = $this->generateTable($oneDumbbellWeight, 1.5, 5, 15);
        $oneDumbbellHtml = $this->renderTable($oneDumbbellData);

        $barbellWeight = [
            5,
            5,
            2.5,
            2.5,
            2.5,
            2.5,
            1.25,
            1.25,
            0.5,
            0.5,
        ];
        $barbellData = $this->generateTable($barbellWeight, 5, 8);
        $barbellHtml = $this->renderTable($barbellData);

        $custom = [
            /*[
                2.5,
                2.5,
                2.5,
                0,
            ],
            [
                2.5,
                2.5,
                2.5,
                0.5,
            ],
            [
                2.5,
                2.5,
                1.25,
                1.25,
            ],
            [
                2.5,
                2.5,
                2.5,
                1.25,
            ],
            [
                2.5,
                2.5,
                2.5,
                2.5,
            ],*/
        ];

        return $this->renderDefault([
            'content' => "
<h2>Две гантели</h2>
$twoDumbbellHtml
<h2>Одна гантель</h2>
$oneDumbbellHtml
<h2>Штанга</h2>
$barbellHtml
",
        ]);
    }

    private function generateTable(array $weight, float $barWeight, int $maxItems): array
    {
        $arr = [];
        $countWeight = count($weight);
        $count = pow(2, $countWeight);
        for ($i = 0; $i < $count; $i++) {
            $bitMask = decbin($i);
            $bitMask = TextHelper::fill($bitMask, $countWeight, '0', 'before');
            $bits = str_split($bitMask);
            foreach ($bits as $index => $bit) {
                $bits[$index] = intval($bit);
            }
            $item = [];
            $itemsCount = 0;
            foreach ($weight as $index => $weightItem) {
                $val = $bits[$index] * $weight[$index];
                $item[] = $val;
                if($val) {
                    $itemsCount++;
                }
            }
//            $sum = $this->sum($item, $barWeight);
            if($itemsCount <= $maxItems) {
//                $item[] = $sum;
                $arr[] = $item;
            }
        }

        /*foreach ($custom as $item) {
            $sum = $this->sum($item, $barWeight);
            $item[] = $sum;
            $arr[] = $item;
        }*/

        $arr = $this->calcSumForList($arr, $barWeight);

        return $arr;
    }

    private function calcSumForList(array $arr, float $barWeight): array {
        $result = [];
        foreach ($arr as &$item) {
            $sum = $this->sum($item, $barWeight);
            if(!isset($result[$sum])) {
                $item[] = $sum;
                $result[$sum] = $item;
            }
        }
        return $result;
    }

    private function sum(array $item, float $barWeight): string
    {
        $sum = array_sum($item) * 2 + $barWeight;
        return strval($sum);
    }

    private function renderTable(array $arr): string
    {
        $table = '';
        $table .= '<table class="table table-striped table-bordered" style="width: 300px">';
        foreach ($arr as $sum => $row) {
            $table .= '<tr>';
            for ($i = 0; $i < count($row); $i++) {
                $val = $row[$i];
                if (empty($val)) {
                    $val = '';
                }
                $table .= '<td>' . $val . '</td>';
            }
//            $table .= '<th>' . $sum . '</th>';
            $table .= '</tr>';
        }
        $table .= '</table>';
        return $table;
    }
}
