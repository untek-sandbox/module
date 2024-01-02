<?php

use Untek\Sandbox\Module\Application\Services\ControllerFinder;
use Untek\Sandbox\Module\Presentation\Http\Site\Controllers\MainPageController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Untek\Core\Instance\Helpers\InstanceHelper;

return function (RoutingConfigurator $routes) {

    $modules = (new ControllerFinder())->find('Forecast\\Map\\Sandbox');
    foreach ($modules as $module) {
        if (!empty($module['controllers'])) {
            foreach ($module['controllers'] as $controller) {
                $controllerInstance = InstanceHelper::create($controller['className']);
                $path = $controller['uri'];
                $routes
                    ->add(hash('crc32b', $path), $path)
                    ->controller($controllerInstance)
                    ->methods(['GET', 'POST']);
            }
        }
    }

    $controller = new MainPageController();

    $routes
        ->add('sandbox/main_page', '/sandbox')
        ->controller($controller)
        ->methods(['GET']);

};
