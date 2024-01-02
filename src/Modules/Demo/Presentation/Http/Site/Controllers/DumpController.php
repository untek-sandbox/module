<?php

namespace Untek\Sandbox\Module\Modules\Demo\Presentation\Http\Site\Controllers;

use Untek\Sandbox\Module\Presentation\Http\Site\Controllers\AbstractSandboxController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DumpController extends AbstractSandboxController
{

    public function __invoke(Request $request): Response
    {
        $this->dump('dump 1');
        $this->dump('dump 2');
        return $this->renderDefault();
    }
}