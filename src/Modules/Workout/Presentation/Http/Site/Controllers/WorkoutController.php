<?php

namespace Untek\Sandbox\Module\Modules\Workout\Presentation\Http\Site\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Untek\Sandbox\Module\Modules\Workout\Domain\Model\Puncake;
use Untek\Sandbox\Module\Modules\Workout\Infrastructure\Service\WorkoutService;
use Untek\Sandbox\Module\Modules\Workout\Presentation\Http\Site\Renders\TableRender;
use Untek\Sandbox\Module\Presentation\Http\Site\Controllers\AbstractSandboxController;

// http://taxi.fk/sandbox/demo/workout

class WorkoutController extends AbstractSandboxController
{

    /**
     * @param array $twoDumbbellWeight
     * @param array $puncakeWidth
     * @return array | Puncake[]
     */
    private function createPuncakes(array $twoDumbbellWeight, array $puncakeWidth): array
    {

        $twoDumbbellWeight2 = [];
        foreach ($twoDumbbellWeight as $weight) {
            $twoDumbbellWeight2[] = new Puncake($weight, $puncakeWidth["$weight"]);
        }
        return $twoDumbbellWeight2;
    }

    private function generatePuncakes(array $puncakeCount, int $rate) {
        $puncakes = [];
        foreach ($puncakeCount as $weight => $count) {
            $itemCount = $count / $rate;
            for($i=0; $i<$itemCount; $i++) {
                $puncakes[] = floatval($weight);
            }
        }
        return $puncakes;
    }

    public function __invoke(Request $request): Response
    {
        $workoutService = new WorkoutService();
        $tableRender = new TableRender();

        $tables = [];

        // ширина грифа гантели под блины - 12см
        $neckWidthDumbbell = 12;
        // ширина грифа штанги под блины - 17.4см
        $neckWidthBarbell = 17.4;

        $puncakeWidth = [
            '5' => 2.825,
            '2.5' => 2.375,
            '1.25' => 1.9125,
            '0.5' => 1.4625,
        ];

        $puncakeCount = [
            '5' => 8,
            '2.5' => 8,
            '1.25' => 4,
            '0.5' => 4,
        ];

        $puncakes = $this->generatePuncakes($puncakeCount, 4);
        $twoDumbbellWeight = $this->createPuncakes($puncakes, $puncakeWidth);
        $twoDumbbellData = $workoutService->generateTable($twoDumbbellWeight, 1.5, $neckWidthDumbbell);
        $tableData['title'] = 'Две гантели';
        $tableData['table'] = $tableRender->renderTable($twoDumbbellData);
        $tables[] = $tableData;

        $puncakes = $this->generatePuncakes($puncakeCount, 2);
        $oneDumbbellWeight = $this->createPuncakes($puncakes, $puncakeWidth);
        $oneDumbbellData = $workoutService->generateTable($oneDumbbellWeight, 1.5, $neckWidthDumbbell);
        $tableData['title'] = 'Одна гантель';
        $tableData['table'] = $tableRender->renderTable($oneDumbbellData);
        $tables[] = $tableData;

        $puncakes = $this->generatePuncakes($puncakeCount, 2);
        $barbellWeight = $this->createPuncakes($puncakes, $puncakeWidth);
        $barbellData = $workoutService->generateTable($barbellWeight, 5, $neckWidthBarbell);
        $tableData['title'] = 'Штанга';
        $tableData['table'] = $tableRender->renderTable($barbellData);
        $tables[] = $tableData;

        $html = '';
        foreach ($tables as $table) {
            $this->toTab($table['title']);
            $this->print($table['table']);
//            $html .= "<h2>{$table['title']}</h2>{$table['table']}";
        }

        return $this->renderDefault([
            'content' => "
<style>

@media print {
    .pagebreak { page-break-before: always; } /* page-break-after works, as well */
}

.page-break {
  page-break-after: always;
}
</style>
$html
",
        ]);
    }
}
