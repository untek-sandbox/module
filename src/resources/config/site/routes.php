<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Untek\Sandbox\Module\Application\Services\RouteGenerator;
use Untek\Sandbox\Module\Presentation\Http\Site\Controllers\MainPageController;

return function (RoutingConfigurator $routes) {
    // SANDBOX_NAMESPACES=Forecast\Map\Sandbox,Untek\Sandbox\Crypt
    $namespaces = explode(',', getenv('SANDBOX_NAMESPACES'));
    (new RouteGenerator())->generate($namespaces, $routes);

    $routes
        ->add('sandbox/main_page', '/sandbox')
        ->controller(new MainPageController())
        ->methods(['GET']);

};
