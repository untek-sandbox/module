<?php

use Untek\Sandbox\Module\Application\Services\ControllerFinder;
use Untek\Sandbox\Module\Presentation\Http\Site\Controllers\MainPageController;
use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Untek\Core\Instance\Helpers\InstanceHelper;

return function (RoutingConfigurator $routes) {

    (new \Untek\Sandbox\Module\Application\Services\RouteGenerator())->generate(['Forecast\\Map\\Sandbox'], $routes);

    $controller = new MainPageController();

    $routes
        ->add('sandbox/main_page', '/sandbox')
        ->controller($controller)
        ->methods(['GET']);

};
