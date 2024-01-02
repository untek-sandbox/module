<?php

namespace Untek\Sandbox\Module\Modules\Example\Presentation\Http\Site\Controllers;

use Untek\Sandbox\Module\Presentation\Http\Site\Controllers\AbstractSandboxController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DownloadFileController extends AbstractSandboxController
{

    public function __invoke(Request $request): Response
    {
        $fileName = __DIR__ . '/../../../../resources/files/symfony.png';
        return $this->downloadFile($fileName);
    }
}