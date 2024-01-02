<?php

namespace Untek\Sandbox\Module\Modules\Example\Presentation\Http\Site\Controllers;

use Untek\Sandbox\Module\Presentation\Http\Site\Controllers\AbstractSandboxController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class RenderTemplateController extends AbstractSandboxController
{

    public function __invoke(Request $request): Response
    {
        return $this->render(__DIR__ . '/../../../../resources/templates/template1.php', [
            'modules' => [
                'module1',
                'module2',
                'module3',
            ],
        ]);
    }
}