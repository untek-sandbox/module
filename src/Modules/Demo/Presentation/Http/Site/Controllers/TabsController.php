<?php

namespace Untek\Sandbox\Module\Modules\Demo\Presentation\Http\Site\Controllers;

use Untek\Sandbox\Module\Presentation\Http\Site\Controllers\AbstractSandboxController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TabsController extends AbstractSandboxController
{

    public function __invoke(Request $request): Response
    {
        $this->print('Main content');

        $this->toTab('Tab 1');
        $this->print('Tab 1 content');

        $this->toTab('Tab 2');
        $this->print('Tab 2 content');

        return $this->renderDefault();
    }
}