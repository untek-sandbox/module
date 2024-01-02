<?php

namespace Untek\Sandbox\Module\Modules\Google\Presentation\Http\Site\Controllers;

use Untek\Sandbox\Module\Presentation\Http\Site\Controllers\AbstractSandboxController;
use Stichoza\GoogleTranslate\GoogleTranslate;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class TranslateController extends AbstractSandboxController
{

    public static function title(): ?string
    {
        return 'Google переводчик';
    }

    public function __invoke(Request $request): Response
    {
        $tr = new GoogleTranslate('en');
        $tr->setTarget('ru');
        $message = $tr->translate('Hello World!');
        $this->alertInfo($message);

        return $this->renderDefault();
    }
}