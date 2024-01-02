<?php

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;

return function (RoutingConfigurator $routes) {

    if(getenv('APP_ENV') !== 'prod' && is_dir(__DIR__ . '/../../../vendor/untek-sandbox/module')) {
        $routes
            ->import(__DIR__ . '/../../../vendor/untek-sandbox/module/src/resources/config/site/routes.php');
    }
};
