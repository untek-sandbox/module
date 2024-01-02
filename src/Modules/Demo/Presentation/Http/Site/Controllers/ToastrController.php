<?php

namespace Untek\Sandbox\Module\Modules\Demo\Presentation\Http\Site\Controllers;

use Untek\Sandbox\Module\Presentation\Http\Site\Controllers\AbstractSandboxController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class ToastrController extends AbstractSandboxController
{

    public function __invoke(Request $request): Response
    {
        $this->getToastr()->success('success');
        $this->getToastr()->warning('warning');
        $this->getToastr()->error('error');
        $this->getToastr()->info('info');
        return $this->renderDefault();
    }
}