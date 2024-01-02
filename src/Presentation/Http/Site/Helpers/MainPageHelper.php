<?php

namespace Untek\Sandbox\Module\Presentation\Http\Site\Helpers;

use Untek\Core\FileSystem\Helpers\FilePathHelper;
use Untek\Core\Text\Helpers\Inflector;

class MainPageHelper
{
    
    public static function title(string $className): ?string
    {
        $controllerName = FilePathHelper::fileNameOnly($className);
        $controllerPureName = substr($controllerName, 0, 0 - strlen('Controller'));
        $controllerPureName = substr($controllerName, 0, 0 - strlen('Controller'));
        return Inflector::titleize($controllerPureName);
    }
}