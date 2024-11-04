<?php

namespace Untek\Sandbox\Module;

use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\PhpFileLoader;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;
use Exception;

class SandboxBundle extends AbstractBundle
{

    /**
     * @param ContainerBuilder $container
     * @return void
     * @throws Exception
     */
    public function build(ContainerBuilder $container)
    {
//        dd(66);
        $fileLocator = new FileLocator(__DIR__);
        $loader = new PhpFileLoader($container, $fileLocator);
//        $loader->load(__DIR__ . '/resources/config/services/console.php');
        $loader->load(__DIR__ . '/resources/config/services/main.php');
    }
}
