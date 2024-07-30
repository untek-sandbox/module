<?php

namespace Untek\Sandbox\Module\Modules\Workout\Application\Handlers;

use Untek\Sandbox\Module\Modules\Workout\Application\Commands\GenerateTableCommand;
use Untek\Sandbox\Module\Modules\Workout\Domain\Model\Puncake;
use Untek\Sandbox\Module\Modules\Workout\Infrastructure\Service\WorkoutService;

class GenerateTableCommandHandler
{

    public function __invoke(GenerateTableCommand $command)
    {
        $workoutService = new WorkoutService();
        $puncakes = $this->generatePuncakes($command->getSuite()->getPuncakeSuite(), $command->getPuncakeCount());
        $puncakeCollection = $this->createPuncakes($puncakes, $command->getSuite()->getPuncakeWidth());
        $dataForTable = $workoutService->generateTable($puncakeCollection, $command->getDevice()->getBarWeight(), $command->getDevice()->getNeckWidth());

        /*foreach ($dataForTable as &$item) {
            foreach ($item['puncackes'] as $field => $value) {
                if(empty($value)) {
                    unset($item['puncackes'][$field]);
                }
            }
        }*/

        $maxCount = 0;
//        foreach ($dataForTable as $item) {
//            if(count($item['puncackes']) > $maxCount) {
//                $maxCount = count($item['puncackes']);
//            }
//        }

        /*foreach ($dataForTable as &$item) {
            if(count($item['puncackes']) < $maxCount) {
                $need = $maxCount - count($item['puncackes']);
                for ($i=0; $i<$need; $i++) {
                    $item['puncackes'][] = 0;
                }
            }
        }*/

//        dd($dataForTable);
//        dd($maxCount);

        return $dataForTable;
    }

    /**
     * @param array $twoDumbbellWeight
     * @param array $puncakeWidth
     * @return array | Puncake[]
     */
    private function createPuncakes(array $twoDumbbellWeight, array $puncakeWidth): array
    {

        $puncakeCollection = [];
        foreach ($twoDumbbellWeight as $weight) {
            $puncakeCollection[] = new Puncake($weight, $puncakeWidth["$weight"]);
        }
        return $puncakeCollection;
    }

    private function generatePuncakes(array $puncakeCount, int $rate)
    {
        $puncakes = [];
        foreach ($puncakeCount as $weight => $count) {
            $itemCount = $count / $rate;
            for ($i = 0; $i < $itemCount; $i++) {
                $puncakes[] = floatval($weight);
            }
        }
        return $puncakes;
    }
}
