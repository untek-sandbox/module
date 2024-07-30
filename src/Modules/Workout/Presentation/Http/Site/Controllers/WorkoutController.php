<?php

namespace Untek\Sandbox\Module\Modules\Workout\Presentation\Http\Site\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Untek\Sandbox\Module\Modules\Workout\Application\Commands\GenerateTableCommand;
use Untek\Sandbox\Module\Modules\Workout\Application\Handlers\GenerateTableCommandHandler;
use Untek\Sandbox\Module\Modules\Workout\Domain\Model\Device;
use Untek\Sandbox\Module\Modules\Workout\Domain\Model\DeviceType;
use Untek\Sandbox\Module\Modules\Workout\Domain\Model\PuncakeSuite;
use Untek\Sandbox\Module\Modules\Workout\Infrastructure\Service\WorkoutService;
use Untek\Sandbox\Module\Modules\Workout\Presentation\Http\Site\Renders\TableRender;
use Untek\Sandbox\Module\Presentation\Http\Site\Controllers\AbstractSandboxController;

// http://taxi.fk/sandbox/demo/workout

class WorkoutController extends AbstractSandboxController
{

    public function __invoke(Request $request): Response
    {
        $handler = new GenerateTableCommandHandler();
        $workoutService = new WorkoutService();
        $tableRender = new TableRender();

        $tables = [];

        $suite = new PuncakeSuite();
        $suite->add('5', 2.825, 8);
        $suite->add('2.5', 2.375, 8);
        $suite->add('1.25', 1.9125, 4);
        $suite->add('0.5', 1.4625, 4);

        $dumbbell = new Device(DeviceType::DUMBBELL, 12, 1.5);
        $barbell = new Device(DeviceType::BARBELL, 17.4, 5);

        $commands = [
            [
                'title' => 'Две гантели',
                'command' => new GenerateTableCommand($dumbbell, $suite, 4),
            ],
            [
                'title' => 'Одна гантель',
                'command' => new GenerateTableCommand($dumbbell, $suite, 2),
            ],
            [
                'title' => 'Штанга',
                'command' => new GenerateTableCommand($barbell, $suite, 2),
            ],
        ];

        foreach ($commands as $item) {
            /** @var GenerateTableCommand $command */
            $command = $item['command'];
            $dataForTable = $handler($command);
            $tableData['title'] = $item['title'];
            $tableData['table'] = $tableRender->renderTable($dataForTable);
            $tables[] = $tableData;
        }

        foreach ($tables as $table) {
            $this->toTab($table['title']);
            $this->print($table['table']);
        }

        return $this->renderDefault();
    }
}
