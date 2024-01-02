<?php

namespace Untek\Sandbox\Module\Application\Services;

use Symfony\Component\Routing\Loader\Configurator\RoutingConfigurator;
use Untek\Core\Instance\Helpers\InstanceHelper;

class RouteGenerator
{

    public function generate(array $namespaces, RoutingConfigurator $routes): void
    {
        foreach ($namespaces as $namespace) {
            $this->generateNamespace($namespace, $routes);
        }
    }

    public function generateNamespace(string $namespace, RoutingConfigurator $routes): void
    {
        $modules = (new ControllerFinder())->findAll([$namespace]);
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
    }
}