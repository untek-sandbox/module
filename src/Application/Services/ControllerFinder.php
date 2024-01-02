<?php

namespace Forecast\Map\Sandbox\MainPage\Application\Services;

use ReflectionClass;
use Untek\Core\FileSystem\Helpers\FilePathHelper;
use Untek\Core\FileSystem\Helpers\FindFileHelper;
use Untek\Core\Text\Helpers\Inflector;

class ControllerFinder
{

    public function find(): array
    {
        $directory = $this->getDirectory();
        $list = FindFileHelper::scanDir($directory);

        $controllers = [];
        foreach ($list as $moduleName) {
            if ($moduleName != 'MainPage') {
                $controllers[] = $this->findControllers($moduleName);
            }
        }

        return $controllers;
    }

    private function findControllers(string $moduleName): array
    {
        $directory = $this->getDirectory();
        $controllersDirectory = $directory . '/' . $moduleName . '/Presentation/Http/Site/Controllers';
        $controllerList = FindFileHelper::scanDir($controllersDirectory);
        $module = [];
        $module['pureName'] = $moduleName;
        foreach ($controllerList as $controllerFileName) {
            $controllerName = FilePathHelper::fileRemoveExt($controllerFileName);
            $controllerPureName = substr($controllerName, 0, 0 - strlen('Controller'));
            $namespace = 'Forecast\\Map\\Sandbox';
            $controller = [
                'namespace' => $namespace,
                'title' => Inflector::titleize($controllerPureName),
                'pureName' => $controllerPureName,
                'fileName' => $controllerFileName,
                'name' => $controllerName,
                'uri' => '/sandbox/' . Inflector::camel2id($moduleName) . '/' . Inflector::camel2id($controllerPureName),
                'className' => $namespace . '\\' . $moduleName . '\\Presentation\\Http\\Site\\Controllers\\' . $controllerName,
            ];
            $rr = new ReflectionClass($controller['className']);
            if(!$rr->isAbstract()) {
                $module['controllers'][] = $controller;
            }
        }
        return $module;
    }

    private function getDirectory(): string
    {
        $directory = __DIR__ . '/../../..';
        $directory = realpath($directory);
        return $directory;
    }
}