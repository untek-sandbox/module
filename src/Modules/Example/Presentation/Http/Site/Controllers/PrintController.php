<?php

namespace Untek\Sandbox\Module\Modules\Example\Presentation\Http\Site\Controllers;

use Untek\Sandbox\Module\Presentation\Http\Site\Controllers\AbstractSandboxController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PrintController extends AbstractSandboxController
{

    public function __invoke(Request $request): Response
    {
        $this->printArray([
            'param1' => 123,
            'param2' => [
                'param1' => 123,
            ]
        ]);
        return $this->renderDefault();
    }
}