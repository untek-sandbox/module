<?php

namespace Untek\Sandbox\Module\Presentation\Http\Site\Controllers;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Untek\Sandbox\Module\Application\Services\ControllerFinder;
use Untek\Sandbox\Module\Presentation\Http\Site\Helpers\MainPageHelper;

abstract class AbstractSandboxMenuController extends AbstractController
{

    public static function menu(): array
    {
        return [];
    }

    public function __invoke(Request $request): Response
    {
        return $this->renderControllerList($this->menu());
    }

    protected function renderControllerList(array $controllerClasses): Response
    {
        $content = $this->generateList($controllerClasses);
        return new Response($content);
    }

    protected function getControllerList(): array
    {
        $namespaces = explode(',', getenv('SANDBOX_NAMESPACES'));
        $modules = (new ControllerFinder())->findAll($namespaces);

        $controllers = [];
        foreach ($modules as $module) {
            foreach ($module['controllers'] as $controller) {
                $controllers[$controller['className']] = $controller['uri'];
            }
        }
        return $controllers;
    }

    protected function generateList(array $controllerClasses): string
    {
        $controllers = $this->getControllerList();
        $html = '<ul>';
        foreach ($controllerClasses as $controllerClassName) {
            $title = MainPageHelper::title($controllerClassName);
            $uri = $controllers[$controllerClassName];

            $html .= "<li><a href='{$uri}'>{$title}</a></li>";
        }
        $html .= '</ul>';
        return $html;
    }
}