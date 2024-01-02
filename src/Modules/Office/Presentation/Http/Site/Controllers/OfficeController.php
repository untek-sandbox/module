<?php

namespace Untek\Sandbox\Module\Modules\Office\Presentation\Http\Site\Controllers;

use Untek\Sandbox\Module\Presentation\Http\Site\Controllers\AbstractSandboxController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Untek\Component\Office\Domain\Libs\DocXRender;

class OfficeController extends AbstractSandboxController
{

    public function __invoke(Request $request): Response
    {
        $templateFile = __DIR__ . '/../../../../resources/doc-x/templates/template.docx';
        $targetDirectory = __DIR__ . '/../../../../../../../var/docX';
        $resultFile = $targetDirectory . '/result_' . date('Y.m.d_H.i.s') . '.docx';

        $replacementList = [
            'title' => 'qwerty123',
            'date' => date('Y.m.d'),
            'time' => date('H:i:s'),
            'param1' => 'param 11111111111111111111',
            'param2' => 'param 22222222222222222222',
        ];

        $doxXRender = new DocXRender();
        $doxXRender->render($templateFile, $resultFile, $replacementList);

        return $this->openFile($resultFile);
    }
}