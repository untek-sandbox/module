<?php

namespace Untek\Sandbox\Module\Modules\Example\Presentation\Http\Site\Controllers;

use Untek\Sandbox\Module\Presentation\Http\Site\Controllers\AbstractSandboxController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AlertController extends AbstractSandboxController
{

    public function __invoke(Request $request): Response
    {
        $this->alertInfo('Info');
        $this->alertDanger('Danger');
        $this->alertWarning('Warning');
        $this->alertSuccess('Success');
        return $this->renderDefault();
    }
}