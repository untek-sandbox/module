<?php

namespace Untek\Sandbox\Module\Modules\Demo\Presentation\Http\Site\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Untek\Sandbox\Module\Presentation\Http\Site\Controllers\AbstractSandboxController;

class TableController extends AbstractSandboxController
{

    public function __invoke(Request $request): Response
    {
        $this->printTable([
            ['key1', 'value1'],
            ['key2', 'value2'],
        ]);
        return $this->renderDefault();
    }
}
