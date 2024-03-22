<?php

namespace Untek\Sandbox\Module\Modules\Demo\Presentation\Http\Site\Controllers;

use Untek\Core\Text\Helpers\TextHelper;
use Untek\Sandbox\Module\Presentation\Http\Site\Controllers\AbstractSandboxController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

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
            [
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
            ],
        ];
        $arr = $this->generateTable($weight, 1.5, $custom);
        return $this->renderDefault([
            'content' => $this->renderTable($arr),
        ]);
    }

    private function generateTable(array $weight, float $barWeight, array $custom): array {
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
            foreach ($weight as $index => $weightItem) {
                $item[] = $bits[$index] * $weight[$index];
            }
            $sum = $this->sum($item, $barWeight);
            $arr[$sum] = $item;
        }

        foreach ($custom as $item) {
            $sum = $this->sum($item, $barWeight);
            $arr[$sum] = $item;
        }

        return $arr;
    }

    private function sum(array $item, float $barWeight): string {
        $sum = array_sum($item) * 2 + $barWeight;
        return strval($sum);
    }

    private function renderTable(array $arr): string {
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
