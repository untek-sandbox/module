<?php

namespace Untek\Sandbox\Module\Modules\Workout\Infrastructure\Service;
// vendor/untek-sandbox/module/src/Modules/Workout/Infrastructure/Service/WorkoutService.php
use Untek\Core\Arr\Helpers\ArrayHelper;
use Untek\Core\Text\Helpers\TextHelper;
use Untek\Sandbox\Module\Modules\Workout\Domain\Model\Puncake;

class WorkoutService
{

    /**
     * @param array | Puncake[] $weight
     * @param float $barWeight
     * @param int $maxItems
     * @return array
     */
    public function generateTable(array $weight, float $barWeight, float $neckWidth): array
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
            $totalWidth = 0;
            foreach ($weight as $index => $puncake) {
                $weightItem = $puncake->getWeight();
                $val = $bits[$index] * $weightItem;
                $item[] = $val;
                if($val) {
                    $itemsCount++;
                    $totalWidth = $totalWidth + $puncake->getWidth();
                }
            }
//            $sum = $this->sum($item, $barWeight);
            if($totalWidth <= $neckWidth) {
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

        ArrayHelper::multisort($arr, 'sum');

        return $arr;
    }

    private function calcSumForList(array $arr, float $barWeight): array {
        $result = [];
        foreach ($arr as &$item) {
            $sum = $this->sum($item, $barWeight);
            $hash = $this->hash($item);
            $item['sum'] = $sum;
            $result[$hash] = $item;
            /*if(!isset($result[$sum])) {
                $item[] = $sum;
                $result[$sum] = $item;
            }*/
        }
        return $result;
    }

    private function hash(array $item): string {
        $hash = [];
        foreach ($item as $field => $value) {
            if($field !== 'sum') {
                if(!empty($value)) {
                    $hash[] = $value;
                }
            }
        }
        return implode(',', $hash);
    }

    private function sum(array $item, float $barWeight): string
    {
        $sum = array_sum($item) * 2 + $barWeight;
        return strval($sum);
    }
}
