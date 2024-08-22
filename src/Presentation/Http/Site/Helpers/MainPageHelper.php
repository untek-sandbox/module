<?php

namespace Untek\Sandbox\Module\Presentation\Http\Site\Helpers;

use Untek\Component\FileSystem\Helpers\FilePathHelper;
use Yiisoft\Strings\Inflector;

class MainPageHelper
{
    
    public static function title(string $className): ?string
    {
        $controllerName = FilePathHelper::fileNameOnly($className);
        $controllerPureName = substr($controllerName, 0, 0 - strlen('Controller'));
        $controllerPureName = substr($controllerName, 0, 0 - strlen('Controller'));
        return (new Inflector())->toSentence($controllerPureName);
    }
}