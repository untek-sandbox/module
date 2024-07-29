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
            $twoDumbbellWeight2[] = new Puncake($weight, $puncakeWidth[$weight]);
        }
        return $twoDumbbellWeight2;
    }

    public function __invoke(Request $request): Response
    {
        $workoutService = new WorkoutService();
        $tableRender = new TableRender();

        // ширина грифа гантели под блины - 12см
        $neckWidthDumbbell = 12;
        // ширина грифа штанги под блины - 17.4см
        $neckWidthBarbell = 17.4;

        $puncakeWidth = [
            5 => 2.825,
            2.5 => 2.375,
            1.25 => 1.9125,
            0.5 => 1.4625,
        ];

        $twoDumbbellWeight = $this->createPuncakes([
            5,
            5,
            2.5,
            2.5,
            1.25,
            0.5,
        ], $puncakeWidth);

        $twoDumbbellData = $workoutService->generateTable($twoDumbbellWeight, 1.5, $neckWidthDumbbell);
        $twoDumbbellHtml = $tableRender->renderTable($twoDumbbellData);

        $oneDumbbellWeight = $this->createPuncakes([
            5,
            5,
            5,
            5,
            2.5,
            2.5,
            2.5,
            2.5,
            1.25,
            1.25,
            0.5,
        ], $puncakeWidth);
        $oneDumbbellData = $workoutService->generateTable($oneDumbbellWeight, 1.5, $neckWidthDumbbell);
        $oneDumbbellHtml = $tableRender->renderTable($oneDumbbellData);

        $barbellWeight = $this->createPuncakes([
            5,
            5,
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
        ], $puncakeWidth);
        $barbellData = $workoutService->generateTable($barbellWeight, 5, $neckWidthBarbell);
        $barbellHtml = $tableRender->renderTable($barbellData);

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
}
