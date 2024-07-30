<?php

namespace Untek\Sandbox\Module\Modules\Workout\Infrastructure\Service;

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
            $puncackes = [];
            $itemsCount = 0;
            $totalWidth = 0;
            foreach ($weight as $index => $puncake) {
                $weightItem = $puncake->getWeight();
                $val = $bits[$index] * $weightItem;
                $puncackes[] = $val;
                if ($val) {
                    $itemsCount++;
                    $totalWidth = $totalWidth + $puncake->getWidth();
                }
            }
            if ($totalWidth <= $neckWidth) {
                $arr[] = [
                    'puncackes' => $puncackes,
                    'sum' => $this->sum($puncackes, $barWeight),
                    'hash' => $this->hash($puncackes),
                ];
            }
        }

        $arr = $this->filterByHash($arr);
        $arr = $this->filterBySum($arr);
        ArrayHelper::multisort($arr, 'sum');

        return $arr;
    }

    private function filterBySum(array $arr): array
    {
        $arr = array_reverse($arr);
        $result = [];
        foreach ($arr as $item) {
            $hash = $item['sum'];
            $result[$hash] = $item;
        }
        return array_reverse($result);
    }

    private function filterByHash(array $arr): array
    {
        $result = [];
        foreach ($arr as $item) {
            $hash = $item['hash'];
            $result[$hash] = $item;
        }
        return $result;
    }

    private function hash(array $item): string
    {
        $hash = [];
        foreach ($item as $field => $value) {
            if ($field !== 'sum') {
                if (!empty($value)) {
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
