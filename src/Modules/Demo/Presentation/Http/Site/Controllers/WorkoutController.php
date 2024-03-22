<?php

namespace Untek\Sandbox\Module\Modules\Demo\Presentation\Http\Site\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Untek\Core\Text\Helpers\TextHelper;
use Untek\Sandbox\Module\Presentation\Http\Site\Controllers\AbstractSandboxController;

class WorkoutController extends AbstractSandboxController
{

    public function __invoke(Request $request): Response
    {
        $weight = [
            2.5,
            2.5,
            1.25,
            0.5,
        ];
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
        $maxItems = 4;
        $arr = $this->generateTable($weight, 1.5, $custom, $maxItems);
        $forTwo = $this->renderTable($arr);

        $weight = [
            2.5,
            2.5,
            2.5,
            2.5,
            1.25,
            1.25,
            0.5,
        ];
        $maxItems = 5;
        $arrOne = $this->generateTable($weight, 1.5, $custom, $maxItems, 15);
        $forOne = $this->renderTable($arrOne);



        return $this->renderDefault([
            'content' => "<h2>Two</h2>$forTwo<h2>One</h2>$forOne", // $this->renderTable($arr),
        ]);
    }

    private function generateTable(array $weight, float $barWeight, array $custom, int $maxItems, float $from = 0): array
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
            $sum = $this->sum($item, $barWeight);
            if($itemsCount <= $maxItems && $sum > $from) {
                $arr[$sum] = $item;
            }
        }

        foreach ($custom as $item) {
            $sum = $this->sum($item, $barWeight);
            $arr[$sum] = $item;
        }


        return $arr;
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
            $table .= '<th>' . $sum . '</th>';
            $table .= '</tr>';
        }
        $table .= '</table>';
        return $table;
    }
}
