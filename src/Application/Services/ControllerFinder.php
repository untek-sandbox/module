<?php

namespace Untek\Sandbox\Module\Application\Services;

use ReflectionClass;
use Untek\Core\Arr\Helpers\ArrayHelper;
use Untek\Core\Code\Helpers\ComposerHelper;
use Untek\Core\FileSystem\Helpers\FilePathHelper;
use Untek\Core\FileSystem\Helpers\FindFileHelper;
use Untek\Core\Text\Helpers\Inflector;
use Untek\Sandbox\Module\Presentation\Http\Site\Helpers\MainPageHelper;

class ControllerFinder
{

    public function findAll(array $namespaces): array
    {
        $modules = [];
        foreach ($namespaces as $namespace) {
            $foundModules = $this->find($namespace);
            $modules = ArrayHelper::merge($modules, $foundModules);
        }
        return $modules;
    }
    
    private function find(string $namespace): array
    {
        $directory = ComposerHelper::getPsr4Path($namespace);
        $list = FindFileHelper::scanDir($directory);
        $controllers = [];
        foreach ($list as $moduleName) {
            if ($moduleName != 'MainPage') {
                $controllers[] = $this->findControllers($moduleName, $namespace . '\\' . $moduleName, $directory . '/' . $moduleName);
            }
        }
        return $controllers;
    }

    private function findControllers(string $moduleName, string $namespace, string $directory): array
    {
        $controllersDirectory = $directory . '/Presentation/Http/Site/Controllers';
        $controllerList = FindFileHelper::scanDir($controllersDirectory);
        $module = [];
        $module['pureName'] = $moduleName;
        $module['namespace'] = $namespace;
        foreach ($controllerList as $controllerFileName) {
            $controllerName = FilePathHelper::fileRemoveExt($controllerFileName);
            $controllerPureName = substr($controllerName, 0, 0 - strlen('Controller'));
            $controllerClassName = $namespace . '\\Presentation\\Http\\Site\\Controllers\\' . $controllerName;
            $title = $controllerClassName::title() ?: MainPageHelper::title($controllerFileName);
            $controller = [
                'namespace' => $namespace,
                'title' => $title,
                'pureName' => $controllerPureName,
                'fileName' => $controllerFileName,
                'name' => $controllerName,
                'uri' => '/sandbox/' . Inflector::camel2id($moduleName) . '/' . Inflector::camel2id($controllerPureName),
                'className' => $controllerClassName,
            ];
            $rr = new ReflectionClass($controller['className']);
            if(!$rr->isAbstract()) {
                $module['controllers'][] = $controller;
            }
        }
        return $module;
    }
}