<?php

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;

/**
 * @var ContainerBuilder $containerBuilder
 */

//$containerBuilder = new ContainerBuilder();
$fileLocator = new FileLocator(__DIR__);
$loader = new PhpFileLoader($containerBuilder, $fileLocator);

// Sandbox
if(getenv('APP_ENV') !== 'prod' && is_dir(__DIR__ . '/../../../vendor/untek-sandbox/module')) {
    $loader->load(__DIR__ . '/../../../vendor/untek-sandbox/module/src/resources/config/services/main.php');
}

return $containerBuilder;
