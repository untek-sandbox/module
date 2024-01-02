<?php

namespace Untek\Sandbox\Module\Presentation\Http\Site\Controllers;

use Untek\Sandbox\Module\Application\Services\ControllerFinder;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class MainPageController extends AbstractSandboxController
{


    public static function title(): string
    {
        return 'Main page';
    }

    public function __invoke(Request $request): Response
    {
        $modules = (new ControllerFinder())->findAll(['Forecast\\Map\\Sandbox']);
        return $this->render(__DIR__ . '/../../../../resources/templates/main-page.php', [
            'modules' => $modules,
        ]);
    }
}